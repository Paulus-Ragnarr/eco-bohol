<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plantation;

class DashboardGraphsController extends Controller
{
    public function currentPlanted()
    {
        $plantations = Plantation::select('unique_code', 'current_planted', 'target_no')->orderBy('status', 'desc')->get();
        return response()->json($plantations);
    }

    public function survivalRate()
    {
        $plantationUnique = Plantation::orderBy('status', 'desc')->get();
        foreach ($plantationUnique as $plantation) {
            $plantation['officer_monitorings'] = $plantation->latest_officer_monitoring;
        }
        return response()->json($plantationUnique);
    }
}