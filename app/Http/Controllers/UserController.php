<?php

namespace App\Http\Controllers;

use App\Units;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index()
    {
        $users = User::where('name','!=','root')->get();
        return view('users.index', compact('users'));
    }
    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $array = $request->except('_token');
        $modal = User::create($array);

        if($request->hasFile('image')){
            $modal->addMedia($request->file('image'))
                ->toMediaCollection('primary');
        }

        if($request->ajax()){
            return response()->json($modal, 200);
        }

        return redirect()->route('user.index')->with('success', 'Successfully Created User!');
    }

    public function update(Request $request, $id)
    {
        $data = User::find($id);
        $array = $request->except('_token');
        $data->update($array);
        if($request->hasFile('image')){
            $data->clearMediaCollection('primary');
            $data->addMedia($request->file('image'))
                ->toMediaCollection('primary');
        }

        return redirect()->route('user.index')->with('success', 'Successfully Updated User!');
    }

    public function show($id)
    {
        $user = User::find($id);
        $role = $user->roles;
        return $role;
        return view('users.edit', compact('user'));
    }

    public function destroy($id)
    {
        $data = User::find($id);
        $data->delete();
        return redirect()->route('user.index')->with('success', 'Successfully Deleted User!');
    }
}
