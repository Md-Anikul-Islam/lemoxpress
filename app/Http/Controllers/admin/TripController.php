<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TripRequest;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index()
    {
        $trip = TripRequest::where('is_complete',1)->latest()->get();
        return view('admin.pages.trip.index',compact('trip'));
    }

    public function inComplete()
    {
        $trip = TripRequest::where('is_complete',0)->latest()->get();
        return view('admin.pages.trip.inCompleteTrip',compact('trip'));
    }
}
