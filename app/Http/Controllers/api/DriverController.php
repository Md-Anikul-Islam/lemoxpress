<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\DriverHistory;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function storeDriver(Request $request)
    {
        $request->validate([
            'did' => 'required',
            'name' => 'required|string',
            'email' => 'required|email|unique:drivers',
            'phone' => 'required|string|unique:drivers',
            'profile' => 'required|image|mimes:jpeg,png,jpg,gif',
            'driving_licence_font_image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'driving_licence_back_image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'rta_card_font_image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'rta_card_back_image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'ratting' => 'numeric|nullable',
        ]);

        $driver = new Driver();
        $driver->did = $request->did;
        $driver->name = $request->name;
        $driver->email = $request->email;
        $driver->phone = $request->phone;
        // Save images to public folder and store their paths in database
        $driver->profile = $request->file('profile')->store('public/images/profile');
        $driver->driving_licence_font_image = $request->file('driving_licence_font_image')->store('public/images/licence');
        $driver->driving_licence_back_image = $request->file('driving_licence_back_image')->store('public/images/licence');
        $driver->rta_card_font_image = $request->file('rta_card_font_image')->store('public/images/rta');
        $driver->rta_card_back_image = $request->file('rta_card_back_image')->store('public/images/rta');
        $driver->ratting = $request->ratting ?? 0;
        $driver->save();

        return response()->json(['driver' => $driver], 201);
    }


    public function storeDriverHistory(Request $request)
    {
        $request->validate([
            'did' => 'required',
            'origin_address' => 'required',
            'destination_address' => 'required',
            'time' => 'required',
            'total_fare' => 'required',
        ]);
        $driver = new DriverHistory();
        $driver->did = $request->did;
        $driver->origin_address = $request->origin_address;
        $driver->destination_address = $request->destination_address;
        $driver->total_fare = $request->total_fare;
        $driver->time = $request->time;
        $driver->save();
        return response()->json(['history' => $driver], 201);
    }

    public function getDriverHistory($did)
    {
        try {
            $diverHistory = DriverHistory::where('did',$did)->with('driver')->latest()->get();
            return response()->json(['history' => $diverHistory], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching data.'], 500);
        }
    }
}
