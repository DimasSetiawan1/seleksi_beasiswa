<?php

namespace App\Services;

class MOORAService
{
    /**
     * Melakukan kalkulasi MOORA.
     * 
     * @param array $candidates Array data kandidat.
     *                          Format: $candidates[$applicant_id] = [ $criteria_id => nilai, ... ]
     * @param array $criteria Bobot & tipe kriteria.
     *                        Format: $criteria[$criteria_id] = ['weight' => float, 'type' => 'benefit'|'cost']
     * @return array
     */
    public function calculate(array $candidates, array $criteria): array
    {
        if (empty($candidates) || empty($criteria)) {
            return [];
        }

        // 1. Menghitung pembagi normalisasi (akar dari jumlah kuadrat tiap kolom kriteria)
        $divisors = [];
        foreach ($criteria as $cId => $cData) {
            $sumSquares = 0;
            foreach ($candidates as $appId => $scores) {
                $val = $scores[$cId] ?? 0;
                $sumSquares += pow($val, 2);
            }
            $divisors[$cId] = sqrt($sumSquares);
        }

        // 2. Normalisasi matriks dan 3. Normalisasi Terbobot + Optimasi (Yi)
        $results = [];
        foreach ($candidates as $appId => $scores) {
            $normalizedScores = [];
            $sumBenefit = 0;
            $sumCost = 0;

            foreach ($criteria as $cId => $cData) {
                $val = $scores[$cId] ?? 0;
                // Normalisasi
                $normVal = $divisors[$cId] > 0 ? $val / $divisors[$cId] : 0;
                $normalizedScores[$cId] = $normVal;

                // Terbobot
                $weightedVal = $normVal * $cData['weight'];

                // Benefit atau Cost
                if ($cData['type'] === 'benefit') {
                    $sumBenefit += $weightedVal;
                } else {
                    $sumCost += $weightedVal;
                }
            }

            // Nilai optimasi
            $yi = $sumBenefit - $sumCost;

            $results[$appId] = [
                'applicant_id'      => $appId,
                'normalized_scores' => $normalizedScores,
                'sum_benefit'       => $sumBenefit,
                'sum_cost'          => $sumCost,
                'yi'                => $yi,
            ];
        }

        // 4. Perangkingan (Sorting by Yi descending)
        usort($results, function ($a, $b) {
            return $b['yi'] <=> $a['yi'];
        });

        // Assign rank
        $rank = 1;
        foreach ($results as $k => $v) {
            $results[$k]['rank'] = $rank++;
        }

        return $results;
    }
}
