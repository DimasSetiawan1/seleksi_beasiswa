<?php

namespace App\Http\Controllers\Ortu;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\ApplicantDocument;
use App\Models\ApplicantScore;
use App\Models\Criteria;
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
        $existingScores = collect();
        if ($period) {
            $applicant = Applicant::with(['documents', 'scores'])->where('user_id', $user->id)->where('period_id', $period->id)->first();
            if ($applicant) {
                $existingScores = $applicant->scores->keyBy('criteria_id');
            }
        }

        $criterias = Criteria::with('subCriterias')->get();

        return view('ortu.pendaftaran.index', compact('period', 'applicant', 'criterias', 'existingScores'));
    }

    public function store(Request $request)
    {
        $period = Period::where('status', 1)->first();
        if (!$period) {
            return redirect()->back()->with('error', 'Tidak ada periode pendaftaran aktif.');
        }

        $validated = $request->validate([
            'nik' => ['required', 'numeric', 'digits:16'],
            'nama_lengkap' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'kelas' => ['required', 'string', 'max:50', 'regex:/^[a-zA-Z0-9\s\-]+$/'],
            'scores' => ['required', 'array'],
        ], [
            'nik.digits' => 'NIK harus berjumlah tepat 16 digit angka.',
            'nik.numeric' => 'NIK hanya boleh berupa angka.',
            'nama_lengkap.regex' => 'Nama lengkap siswa hanya boleh berupa huruf dan spasi (tidak boleh ada angka atau karakter spesial).',
            'kelas.regex' => 'Format kelas tidak valid.',
            'scores.required' => 'Wajib memilih seluruh pilihan kondisi kriteria penilaian.',
        ]);

        $applicant = Applicant::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'period_id' => $period->id
            ],
            [
                'nik' => $validated['nik'],
                'nama_lengkap' => $validated['nama_lengkap'],
                'kelas' => $validated['kelas'],
                'status_berkas' => 'draft'
            ]
        );

        // Save selected sub-criteria values directly into scores
        foreach ($validated['scores'] as $criteriaId => $scoreVal) {
            ApplicantScore::updateOrCreate(
                [
                    'applicant_id' => $applicant->id,
                    'criteria_id' => $criteriaId
                ],
                [
                    'nilai_kriteria' => floatval($scoreVal)
                ]
            );
        }

        return redirect()->back()->with('success', 'Data pendaftaran siswa dan pilihan kriteria berhasil disimpan!');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'applicant_id' => 'required|exists:applicants,id',
            'jenis_dokumen' => 'required|string',
            'file_dokumen' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'file_dokumen.mimes' => 'Format berkas dokumen harus berupa PDF, JPG, JPEG, atau PNG.',
            'file_dokumen.max' => 'Ukuran berkas dokumen tidak boleh melebihi 5 MB.',
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

            // Update status to submitted once document uploaded
            $applicant->update(['status_berkas' => 'submitted']);
        }

        return redirect()->back()->with('success', 'Dokumen berhasil diunggah!');
    }
}
