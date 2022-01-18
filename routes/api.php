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
Route::post('/units', function (Request $request) {

    $unit = \App\Units::create($request->all());
    
    return response()->json([
        'data'=> $unit,
        'status' => 'success'
    ]);
});
Route::put('/units/{id}', function (Request $request, $id) {

    $unit = \App\Units::find($id);
    $unit->update($request->all());

    return response()->json([
        'data'=> $unit,
        'status' => 'imba naka update na!'
    ]);
});
Route::delete('/units/{id}', function (Request $request, $id) {

    $unit = \App\Units::find($id);
    $unit->delete();

    return response()->json([
        'status' => 'mauragun ka man!'
    ]);
});

Route::get('/units/{id}', function (Request $request, $id) {

    $unit = \App\Units::find($id);

    return response()->json([
        'data' => $unit,
        'status' => 'ini na oh!'
    ]);

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
    $units = $unitQuery->orderBy('id','desc')->get();

    return response()->json([
        'data'=> $units,
        'status' => 'success'
    ]);
});
