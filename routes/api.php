<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/test', function (Request $request) {
    return "TEST";
});
Route::get('/units', function (Request $request) {

    $unitQuery = \App\Units::query();
    if($request->has('brand') && $query = $request->input('brand')){
        $unitQuery->where('brand', 'like', '%'.$query.'%');
    }
    if($request->has('model') && $query = $request->input('model')){
        $unitQuery->where('model', 'like', '%'.$query.'%');
    }
    if($request->has('color') && $query = $request->input('color')){
        $unitQuery->where('color', 'like', '%'.$query.'%');
    }
    if($request->has('chassis_no') && $query = $request->input('chassis_no')){
        $unitQuery->where('chassis_no', 'like', '%'.$query.'%');
    }
    if($request->has('bnew_repo') && $query = $request->input('bnew_repo')){
        $unitQuery->where('bnew_repo', 'like', '%'.$query.'%');
    }
    $units = $unitQuery->get();

    return response()->json([
        'data'=>$units,
        'status' => 'success'
    ]);
});
