<?php

namespace App\Http\Controllers;

use App\Clients;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    //
    public function index()
    {
        $clients = Clients::all();
        return view('clients.index', compact('clients'));
    }
}
