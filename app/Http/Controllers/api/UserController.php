<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserHistory;
use Illuminate\Http\Request;

class UserController extends Controller
{


    public function storeUser(Request $request)
    {
        $request->validate([
            'uid' => 'required',
            'name' => 'required|string',
            'email' => 'required',
            'phone' => 'required|string|unique:drivers',
            'userProfile' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);
        $user = new User();
        $user->uid = $request->uid;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->userProfile = $request->file('userProfile')->store('public/images/userProfile');
        $user->save();
        return response()->json(['user' => $user], 201);
    }

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
