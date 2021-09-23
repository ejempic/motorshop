<?php

namespace App\Http\Controllers;

use App\Units;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    //
    public function index()
    {
        $units = Units::with('media')
            ->where('bnew_repo', 'bnew')
            ->orderBy('id','desc')
            ->get();
        return view('units.index', compact('units'));
    }
    public function create()
    {
        return view('units.create');
    }

    public function store(Request $request)
    {
        $array = $request->except('_token');
        $array['bnew_repo'] = 'bnew';
        $array['color'] = array_filter($array['color'], function($color){return $color;});
        $array['color'] = implode(',', $array['color']);
        $modal = Units::create($array);

        if($request->hasFile('image')){
            $modal->addMedia($request->file('image'))
                ->toMediaCollection('primary');
        }

        if($request->ajax()){
            return response()->json($modal, 200);
        }


        return redirect()->route('unit.index')->with('success', 'Successfully Created Unit!');
    }

    public function update(Request $request, $id)
    {
        $data = Units::find($id);
        $array = $request->except('_token');
        $array['color'] = array_filter($array['color'], function($color){return $color;});
        $array['color'] = implode(',', $array['color']);
        $data->update($array);
        if($request->hasFile('image')){
            $data->clearMediaCollection('primary');
            $data->addMedia($request->file('image'))
                ->toMediaCollection('primary');
        }


        return redirect()->route('unit.index')->with('success', 'Successfully Updated Unit!');
    }

    public function show($id)
    {
        $data = Units::find($id);
        $data['color'] = explode(',', $data['color']);
        return view('units.edit', compact('data'));
    }

    public function destroy($id)
    {
        $data = Units::find($id);
        $data->delete();
        $data->clearMediaCollection();
        return redirect()->route('unit.index')->with('success', 'Successfully Deleted Unit!');
    }
}
