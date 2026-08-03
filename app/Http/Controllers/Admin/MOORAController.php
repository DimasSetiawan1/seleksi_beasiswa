<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Criteria;
use App\Models\MooraResult;
use App\Models\Period;
use App\Models\Proposal;
use App\Services\MOORAService;
use Illuminate\Http\Request;

class MOORAController extends Controller
{
    protected MOORAService $mooraService;

    public function __construct(MOORAService $mooraService)
    {
        $this->mooraService = $mooraService;
    }

    public function index()
    {
        $period = Period::where('status', 1)->first();
        $mooraResults = [];
        $proposal = null;

        if ($period) {
            $mooraResults = MooraResult::with('applicant')
                ->where('period_id', $period->id)
                ->orderBy('rank', 'asc')
                ->get();

            $proposal = Proposal::where('period_id', $period->id)->first();
        }

        return view('admin.moora.index', compact('period', 'mooraResults', 'proposal'));
    }

    public function calculate(Request $request)
    {
        $period = Period::where('status', 1)->first();
        if (!$period) {
            return redirect()->back()->with('error', 'Tidak ada periode aktif.');
        }

        $criterias = Criteria::all()->keyBy('id');
        if ($criterias->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada kriteria penilaian.');
        }

        $criteriaData = [];
        foreach ($criterias as $c) {
            $criteriaData[$c->id] = [
                'weight' => floatval($c->bobot ?? (1 / $criterias->count())),
                'type' => $c->tipe
            ];
        }

        // Gather applicants with complete scores
        $applicants = Applicant::with('scores')->where('period_id', $period->id)->get();

        $candidatesData = [];
        foreach ($applicants as $app) {
            if ($app->scores->count() > 0) {
                foreach ($app->scores as $s) {
                    $candidatesData[$app->id][$s->criteria_id] = $s->nilai_kriteria;
                }
            }
        }

        if (empty($candidatesData)) {
            return redirect()->back()->with('error', 'Belum ada kandidat yang memiliki nilai kriteria.');
        }

        $results = $this->mooraService->calculate($candidatesData, $criteriaData);

        // Clear existing and save new results
        MooraResult::where('period_id', $period->id)->delete();

        foreach ($results as $res) {
            MooraResult::create([
                'period_id' => $period->id,
                'applicant_id' => $res['applicant_id'],
                'nilai_optimasi_yi' => $res['yi'],
                'rank' => $res['rank']
            ]);
        }

        // Create or update draft proposal for Kepsek review
        Proposal::updateOrCreate(
            ['period_id' => $period->id],
            ['status' => 'draft']
        );

        return redirect()->back()->with('success', 'Kalkulasi MOORA berhasil dijalankan dan peringkat kandidat diperbarui!');
    }

    public function sendProposal(Request $request)
    {
        $period = Period::where('status', 1)->first();
        if ($period) {
            Proposal::updateOrCreate(
                ['period_id' => $period->id],
                ['status' => 'submitted']
            );
        }
        return redirect()->back()->with('success', 'Daftar usulan penerima beasiswa berhasil dikirim ke Kepala Sekolah!');
    }
}
