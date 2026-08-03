<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CandidatesExport;
use App\Http\Controllers\Controller;
use App\Models\MooraResult;
use App\Models\Period;
use App\Models\Proposal;
use App\Models\SkDocument;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        $period = Period::where('status', 1)->first();
        $mooraResults = [];
        $skDocument = null;

        if ($period) {
            $mooraResults = MooraResult::with('applicant')
                ->where('period_id', $period->id)
                ->orderBy('rank', 'asc')
                ->get();

            $skDocument = SkDocument::where('period_id', $period->id)->first();
        }

        return view('admin.laporan.index', compact('period', 'mooraResults', 'skDocument'));
    }

    public function exportPdf()
    {
        $period = Period::where('status', 1)->first();
        if (!$period) return redirect()->back()->with('error', 'Tidak ada periode aktif.');

        $mooraResults = MooraResult::with('applicant')->where('period_id', $period->id)->orderBy('rank', 'asc')->get();
        $proposal = Proposal::where('period_id', $period->id)->first();

        $pdf = Pdf::loadView('pdf.sk_penetapan', compact('period', 'mooraResults', 'proposal'));
        return $pdf->download('laporan_hasil_seleksi_beasiswa_' . $period->id . '.pdf');
    }

    public function exportExcel()
    {
        $period = Period::where('status', 1)->first();
        if (!$period) return redirect()->back()->with('error', 'Tidak ada periode aktif.');

        return Excel::download(new CandidatesExport($period->id), 'laporan_ranking_beasiswa_' . $period->id . '.xlsx');
    }
}
