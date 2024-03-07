<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\UserHistory;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function storeUserHistory(Request $request)
    {
        $request->validate([
            'uid' => 'required',
            'origin_address' => 'required',
            'destination_address' => 'required',
            'time' => 'required',
            'total_fare' => 'required',
        ]);
        $driver = new UserHistory();
        $driver->uid = $request->uid;
        $driver->origin_address = $request->origin_address;
        $driver->destination_address = $request->destination_address;
        $driver->total_fare = $request->total_fare;
        $driver->time = $request->time;
        $driver->save();
        return response()->json(['history' => $driver], 201);
    }
}
