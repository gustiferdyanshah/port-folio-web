<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Treatments;

class TreatmentController extends Controller
{
    public function index()
    {
        $treatments = Treatments::all();
        return view('pelanggan.treatments-index', compact('treatments'));
    }

    public function show($id)
    {
        $treatment = Treatments::findOrFail($id);
        return view('pelanggan.treatments-show', compact('treatment'));
    }

    
}
