<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DriverSpecialOffersController extends Controller
{
    public function index(Request $request)
    {
        $special_offers = [];
        return view('driver.special_offers.index', compact('special_offers'));
    }

}
