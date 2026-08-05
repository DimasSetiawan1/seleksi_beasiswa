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

        $user = auth()->user();

        // Cek apakah sudah ada applicant (untuk lock NIK)
        $existingApplicant = Applicant::where('user_id', $user->id)
            ->where('period_id', $period->id)
            ->first();

        $nikAlreadySet = $existingApplicant && $existingApplicant->nik;

        // Rules validasi
        $rules = [
            'nama_lengkap' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'scores'       => ['required', 'array'],
        ];

        $messages = [
            'nama_lengkap.regex'   => 'Nama lengkap hanya boleh berisi huruf dan spasi, tanpa angka atau karakter spesial.',
            'scores.required'      => 'Wajib memilih seluruh pilihan kondisi kriteria penilaian.',
        ];

        // Validasi NIK hanya jika belum terkunci
        if (!$nikAlreadySet) {
            $rules['nik'] = [
                'required',
                'numeric',
                'digits:16',
                function ($attribute, $value, $fail) use ($existingApplicant) {
                    // NIK tidak boleh semua angka yang sama (e.g. 0000000000000000)
                    if (preg_match('/^(.)\1{15}$/', $value)) {
                        $fail('NIK tidak valid. Pastikan NIK sesuai dengan KTP/KK.');
                        return;
                    }
                    // Cek duplikat NIK dari applicant lain
                    $duplicate = \App\Models\Applicant::where('nik', $value)
                        ->when($existingApplicant, fn($q) => $q->where('id', '!=', $existingApplicant->id))
                        ->exists();
                    if ($duplicate) {
                        $fail('NIK tersebut sudah terdaftar oleh pendaftar lain.');
                    }
                },
            ];
            $messages['nik.digits']   = 'NIK harus berjumlah tepat 16 digit angka.';
            $messages['nik.numeric']  = 'NIK hanya boleh berupa angka.';
        }

        $validated = $request->validate($rules, $messages);

        $applicantData = [
            'nama_lengkap'  => $validated['nama_lengkap'],
            'status_berkas' => 'draft',
        ];

        // Hanya set NIK jika belum ada
        if (!$nikAlreadySet) {
            $applicantData['nik'] = $validated['nik'];
        }

        $applicant = Applicant::updateOrCreate(
            [
                'user_id'   => $user->id,
                'period_id' => $period->id,
            ],
            $applicantData
        );

        // Save selected sub-criteria values directly into scores
        foreach ($validated['scores'] as $criteriaId => $scoreVal) {
            ApplicantScore::updateOrCreate(
                [
                    'applicant_id' => $applicant->id,
                    'criteria_id'  => $criteriaId
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
