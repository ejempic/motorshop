<?php

namespace App\Http\Controllers;

use App\Clients;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    //
    public function index()
    {
        $clients = Clients::orderBy('id','desc')
            ->get();
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $client = Clients::create($request->except('_token'));

        if($request->hasFile('image')){
            $client->addMedia($request->file('image'))
                ->toMediaCollection('primary');
        }

        if($request->ajax()){
            return response()->json($client, 200);
        }

        return redirect()->route('client.index')->with('success', 'Successfully Created Client!');
    }

    public function update(Request $request, $id)
    {
        $client = Clients::find($id);
        $client->update($request->except('_token'));

        if($request->hasFile('image')){
            $client->clearMediaCollection('primary');
            $client->addMedia($request->file('image'))
                ->toMediaCollection('primary');
        }
        return redirect()->route('client.index')->with('success', 'Successfully Updated Client!');
    }

    public function show($id)
    {
        $client = Clients::find($id);

        return view('clients.edit', compact('client'));
    }

    public function destroy($id)
    {
        $client = Clients::find($id);
        $client->delete();
        $client->clearMediaCollection('primary');
        return redirect()->route('client.index')->with('success', 'Successfully Deleted Client!');
    }
}
