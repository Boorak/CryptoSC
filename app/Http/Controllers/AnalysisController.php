<?php

namespace App\Http\Controllers;

use App\Analysis;
use Illuminate\Http\Response;

class AnalysisController extends Controller
{

    public function index()
    {
        return view('analysisChart.index');
    }

    public function store()
    {
        \request()->validate([
            'image_url' => 'required',
            'analysis_data' => 'required',
        ]);

        $analysis = Analysis::addAnalysis();

        return response()->json(
            [
                "message" => "analysis data has been added",
                "analysis_id" => $analysis->id,
            ],
            Response::HTTP_CREATED
        );
    }
}


