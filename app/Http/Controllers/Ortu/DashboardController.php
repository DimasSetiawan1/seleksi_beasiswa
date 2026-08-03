<?php

namespace App\Http\Controllers\Ortu;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Period;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $period = Period::where('status', 1)->first();
        $applicant = null;

        if ($period) {
            $applicant = Applicant::where('user_id', $user->id)->where('period_id', $period->id)->first();
        }

        return view('ortu.dashboard', compact('period', 'applicant'));
    }
}
