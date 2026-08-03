<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\ApplicantScore;
use App\Models\Criteria;
use App\Models\Period;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function index()
    {
        $period = Period::where('status', 1)->first();
        $applicants = [];
        if ($period) {
            $applicants = Applicant::with(['user', 'documents', 'scores'])
                ->where('period_id', $period->id)
                ->get();
        }

        return view('admin.kandidat.index', compact('period', 'applicants'));
    }

    public function show($id)
    {
        $applicant = Applicant::with(['user', 'documents', 'scores'])->findOrFail($id);
        $criterias = Criteria::with('subCriterias')->get();
        $existingScores = $applicant->scores->keyBy('criteria_id');

        return view('admin.kandidat.show', compact('applicant', 'criterias', 'existingScores'));
    }

    public function verify(Request $request, $id)
    {
        $applicant = Applicant::findOrFail($id);
        $status = $request->input('status_berkas');

        if (in_array($status, ['verifikasi', 'ditolak', 'diterima', 'submitted'])) {
            $applicant->update(['status_berkas' => $status]);
        }

        return redirect()->back()->with('success', 'Status berkas kandidat berhasil diperbarui!');
    }

    public function storeScore(Request $request, $id)
    {
        $applicant = Applicant::findOrFail($id);
        $scores = $request->input('scores', []);

        foreach ($scores as $criteriaId => $val) {
            ApplicantScore::updateOrCreate(
                [
                    'applicant_id' => $applicant->id,
                    'criteria_id' => $criteriaId,
                ],
                [
                    'nilai_kriteria' => floatval($val),
                ]
            );
        }

        return redirect()->back()->with('success', 'Nilai kriteria kandidat berhasil disimpan!');
    }
}
