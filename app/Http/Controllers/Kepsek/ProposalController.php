<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\MooraResult;
use App\Models\Period;
use App\Models\Proposal;
use App\Models\SkDocument;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ProposalController extends Controller
{
    public function index()
    {
        $period = Period::where('status', 1)->first();
        $proposal = null;
        $mooraResults = [];

        if ($period) {
            $proposal = Proposal::where('period_id', $period->id)->first();
            $mooraResults = MooraResult::with('applicant')
                ->where('period_id', $period->id)
                ->orderBy('rank', 'asc')
                ->get();
        }

        return view('kepsek.usulan.index', compact('period', 'proposal', 'mooraResults'));
    }

    public function approve(Request $request, $id)
    {
        $proposal = Proposal::findOrFail($id);
        $proposal->update([
            'status' => 'approved',
            'catatan_kepsek' => $request->input('catatan_kepsek', 'Disetujui oleh Kepala Sekolah.')
        ]);

        // Generate SK Penetapan PDF automatically
        $period = Period::find($proposal->period_id);
        $mooraResults = MooraResult::with('applicant')->where('period_id', $period->id)->orderBy('rank', 'asc')->get();

        $pdf = Pdf::loadView('pdf.sk_penetapan', compact('period', 'mooraResults', 'proposal'));
        
        $fileName = 'sk_penetapan_periode_' . $period->id . '.pdf';
        $path = 'sk_documents/' . $fileName;
        Storage::disk('public')->put($path, $pdf->output());

        SkDocument::updateOrCreate(
            ['period_id' => $period->id],
            [
                'path_file' => $path,
                'ditandatangani_oleh' => auth()->id(),
                'tgl_tanda_tangan' => now(),
            ]
        );

        return redirect()->back()->with('success', 'Daftar usulan telah DISETUJUI dan SK Penetapan PDF berhasil dibuat!');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'catatan_kepsek' => 'required|string|min:10',
        ]);

        $proposal = Proposal::findOrFail($id);
        $proposal->update([
            'status' => 'rejected',
            'catatan_kepsek' => $request->input('catatan_kepsek')
        ]);

        return redirect()->back()->with('success', 'Daftar usulan dikembalikan ke Admin untuk direvisi.');
    }
}
