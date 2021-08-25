<?php

namespace App\Http\Controllers;

use App\Units;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    //
    public function index()
    {
        $units = Units::all();
        return view('units.index', compact('units'));
    }
}
