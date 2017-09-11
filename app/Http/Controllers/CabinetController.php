<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\TransportCategory;
use Illuminate\Http\Request;

class CabinetController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $services = Service::orderBy('name', 'asc')->get();
        $transportCategories = TransportCategory::orderBy('name', 'asc')->get();

        if(auth()->user()->isDriver())
        {
            return view('driver.dashboard',compact('transportCategories'));
        }

        return view('cabinet.dashboard', compact('services','transportCategories'));
    }

    public function privacy()
    {
        return view('cabinet.privacy');
    }
}
