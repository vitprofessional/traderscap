<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BrokerFinderController extends Controller
{
    public function chooser()
    {
        return view('customer.broker-chooser');
    }

    public function index()
    {
        return view('customer.broker-finder');
    }
}
