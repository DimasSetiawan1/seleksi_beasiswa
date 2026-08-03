<?php

namespace App\Services;

class AHPService
{
    /**
     * Tabel Random Index (RI) sesuai standar Saaty.
     * Index 0 tidak dipakai (atau untuk n=1), n max 15.
     */
    protected array $riTable = [
        1 => 0.00,
        2 => 0.00,
        3 => 0.58,
        4 => 0.90,
        5 => 1.12,
        6 => 1.24,
        7 => 1.32,
        8 => 1.41,
        9 => 1.45,
        10 => 1.49,
        11 => 1.51,
        12 => 1.48,
        13 => 1.56,
        14 => 1.57,
        15 => 1.59,
    ];

    /**
     * Melakukan kalkulasi AHP.
     * 
     * @param array $matrix Matriks n x n, di mana key-nya adalah ID kriteria.
     *                      Format: $matrix[$id_i][$id_j] = nilai
     * @return array
     */
    public function calculate(array $matrix): array
    {
        $n = count($matrix);
        if ($n === 0) {
            return [];
        }

        // 1. Menghitung total tiap kolom
        $colTotals = [];
        $criteriaIds = array_keys($matrix);
        foreach ($criteriaIds as $j) {
            $colTotals[$j] = 0;
            foreach ($criteriaIds as $i) {
                $colTotals[$j] += $matrix[$i][$j];
            }
        }

        // 2. Normalisasi matriks dan hitung Eigen Vector (Bobot)
        $normalizedMatrix = [];
        $eigenVectors = []; // priority vectors
        foreach ($criteriaIds as $i) {
            $rowSum = 0;
            foreach ($criteriaIds as $j) {
                // hindari division by zero
                $val = $colTotals[$j] > 0 ? $matrix[$i][$j] / $colTotals[$j] : 0;
                $normalizedMatrix[$i][$j] = $val;
                $rowSum += $val;
            }
            $eigenVectors[$i] = $rowSum / $n;
        }

        // 3. Menghitung Lambda Max
        $lambdaMax = 0;
        foreach ($criteriaIds as $i) {
            $lambdaMax += $colTotals[$i] * $eigenVectors[$i];
        }

        // 4. Menghitung Consistency Index (CI)
        // CI = (LambdaMax - n) / (n - 1)
        if ($n > 1) {
            $ci = ($lambdaMax - $n) / ($n - 1);
        } else {
            $ci = 0;
        }

        // 5. Menghitung Consistency Ratio (CR)
        $ri = $this->riTable[$n] ?? 1.59; // Default if n > 15
        if ($ri > 0) {
            $cr = $ci / $ri;
        } else {
            $cr = 0; // Untuk n=1 atau n=2, CR=0 dan selalu konsisten
        }

        return [
            'matrix'           => $matrix,
            'normalizedMatrix' => $normalizedMatrix,
            'eigenVectors'     => $eigenVectors,
            'lambdaMax'        => $lambdaMax,
            'ci'               => $ci,
            'ri'               => $ri,
            'cr'               => $cr,
            'isConsistent'     => $cr <= 0.1,
        ];
    }
}
