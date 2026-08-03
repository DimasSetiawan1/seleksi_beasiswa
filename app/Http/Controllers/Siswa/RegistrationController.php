<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\ApplicantDocument;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RegistrationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $period = Period::where('status', 1)->first();
        
        $applicant = null;
        if ($period) {
            $applicant = Applicant::with('documents')->where('user_id', $user->id)->where('period_id', $period->id)->first();
        }

        return view('siswa.pendaftaran.index', compact('period', 'applicant'));
    }

    public function store(Request $request)
    {
        $period = Period::where('status', 1)->first();
        if (!$period) {
            return redirect()->back()->with('error', 'Tidak ada periode pendaftaran aktif.');
        }

        $validated = $request->validate([
            'nik' => 'required|string|max:20',
            'nama_lengkap' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
        ]);

        $applicant = Applicant::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'period_id' => $period->id
            ],
            array_merge($validated, [
                'status_berkas' => 'draft'
            ])
        );

        return redirect()->back()->with('success', 'Data pribadi berhasil disimpan.');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'applicant_id' => 'required|exists:applicants,id',
            'jenis_dokumen' => 'required|string',
            'file_dokumen' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $applicant = Applicant::findOrFail($request->applicant_id);

        if ($file = $request->file('file_dokumen')) {
            $path = $file->store('documents', 'public');

            ApplicantDocument::updateOrCreate(
                [
                    'applicant_id' => $applicant->id,
                    'jenis_dokumen' => $request->jenis_dokumen,
                ],
                [
                    'path_file' => $path,
                    'status_verifikasi' => false,
                ]
            );

            // Set applicant status to submitted if form & document exists
            $applicant->update(['status_berkas' => 'submitted']);
        }

        return redirect()->back()->with('success', 'Dokumen berhasil diunggah!');
    }
}
