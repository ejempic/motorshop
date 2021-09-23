<?php

namespace App\Http\Controllers;

use App\Units;
use Illuminate\Http\Request;

class RepoController extends Controller
{
    //
    public function index()
    {
        $units = Units::where('bnew_repo', 'repo')->get();
        return view('repo.index', compact('units'));
    }
    public function create()
    {
        return view('repo.create');
    }

    public function store(Request $request)
    {
        $array = $request->except('_token');
        $array['bnew_repo'] = 'repo';
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

        return redirect()->route('repo.index')->with('success', 'Successfully Created Unit!');
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

        return redirect()->route('repo.index')->with('success', 'Successfully Updated Unit!');
    }

    public function show($id)
    {
        $data = Units::find($id);
        $data['color'] = explode(',', $data['color']);
        return view('repo.edit', compact('data'));
    }

    public function destroy($id)
    {
        $data = Units::find($id);
        $data->delete();
        return redirect()->route('repo.index')->with('success', 'Successfully Deleted Unit!');
    }
}
