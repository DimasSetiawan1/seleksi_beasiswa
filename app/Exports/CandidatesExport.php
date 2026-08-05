<?php

namespace App\Exports;

use App\Models\MooraResult;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CandidatesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $periodId;

    public function __construct($periodId)
    {
        $this->periodId = $periodId;
    }

    public function collection()
    {
        return MooraResult::with('applicant')
            ->where('period_id', $this->periodId)
            ->orderBy('rank', 'asc')
            ->get();
    }

    public function headings(): array
    {
        return ['Ranking', 'NIK', 'Nama Lengkap', 'Nilai Optimasi MOORA'];
    }

    public function map($row): array
    {
        return [
            $row->rank,
            $row->applicant->nik ?? '',
            $row->applicant->nama_lengkap ?? '',
            $row->nilai_optimasi_yi,
        ];
    }
}
