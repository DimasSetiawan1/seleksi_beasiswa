<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Criteria;
use App\Models\Period;
use App\Models\AhpMatrix;
use App\Models\AhpResult;
use App\Services\AHPService;
use Illuminate\Http\Request;

class AHPController extends Controller
{
    protected AHPService $ahpService;

    public function __construct(AHPService $ahpService)
    {
        $this->ahpService = $ahpService;
    }

    public function index()
    {
        $period = Period::where('status', 1)->first();
        $criterias = Criteria::all();
        
        $ahpResults = [];
        $existingMatrix = [];
        $calculation = null;

        if ($period && $criterias->count() > 0) {
            // Load existing matrix if stored
            $matrices = AhpMatrix::where('period_id', $period->id)->get();
            foreach ($matrices as $m) {
                $existingMatrix[$m->criteria_i_id][$m->criteria_j_id] = $m->nilai_perbandingan;
            }

            // Load existing results
            $ahpResults = AhpResult::where('period_id', $period->id)->get()->keyBy('criteria_id');
        }

        return view('admin.ahp.index', compact('period', 'criterias', 'existingMatrix', 'ahpResults', 'calculation'));
    }

    public function calculate(Request $request)
    {
        $period = Period::where('status', 1)->first();
        if (!$period) {
            return redirect()->back()->with('error', 'Tidak ada periode aktif.');
        }

        $criterias = Criteria::all();
        $matrix = $request->input('matrix', []);

        // Validate matrix completion & reciprocal consistency
        $formattedMatrix = [];
        foreach ($criterias as $ci) {
            foreach ($criterias as $cj) {
                if ($ci->id == $cj->id) {
                    $formattedMatrix[$ci->id][$cj->id] = 1.0;
                } else {
                    $val = floatval($matrix[$ci->id][$cj->id] ?? 1.0);
                    $formattedMatrix[$ci->id][$cj->id] = $val;
                }
            }
        }

        $calculation = $this->ahpService->calculate($formattedMatrix);

        if ($calculation['isConsistent']) {
            // Save to DB
            AhpMatrix::where('period_id', $period->id)->delete();
            foreach ($criterias as $ci) {
                foreach ($criterias as $cj) {
                    AhpMatrix::create([
                        'period_id' => $period->id,
                        'criteria_i_id' => $ci->id,
                        'criteria_j_id' => $cj->id,
                        'nilai_perbandingan' => $formattedMatrix[$ci->id][$cj->id],
                    ]);
                }
            }

            AhpResult::where('period_id', $period->id)->delete();
            foreach ($calculation['eigenVectors'] as $criteriaId => $weight) {
                AhpResult::create([
                    'period_id' => $period->id,
                    'criteria_id' => $criteriaId,
                    'bobot_eigen' => $weight,
                    'cr' => $calculation['cr'],
                    'is_consistent' => true,
                ]);

                // Update criteria weight
                Criteria::where('id', $criteriaId)->update(['bobot' => $weight]);
            }
        }

        $existingMatrix = $formattedMatrix;
        $ahpResults = AhpResult::where('period_id', $period->id)->get()->keyBy('criteria_id');

        return view('admin.ahp.index', compact('period', 'criterias', 'existingMatrix', 'ahpResults', 'calculation'));
    }
}
