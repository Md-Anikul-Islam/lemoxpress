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
            'userProfile' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        // Check if at least one of phone or email is filled
        if (empty($request->phone) && empty($request->email)) {
            return response()->json(['error' => 'Either phone or email must be filled.'], 422);
        }

        $user = new User();
        $user->uid = $request->uid;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = 2;

        if ($request->userProfile) {
            $userProfile = time().'.'.$request->userProfile->extension();
            $request->userProfile->move(public_path('images/userProfile'), $userProfile);
            $user->userProfile = $userProfile;
        }

        $user->save();
        return response()->json(['user' => $user,'message' => 'User Register Success'], 201);
    }



    public function loginUser(Request $request)
    {
        $request->validate([
            'phone' => 'required',
        ]);

        $user = User::where('phone', $request->phone)->first();

        if ($user) {
            // Selecting specific fields from the user object
            $userData = [
                'id' => $user->id,
                'uid' => $user->uid,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => (int)$user->role,
                'userProfile' => $user->userProfile,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ];

            return response()->json(['user' => $userData,'message' => 'User Found'], 200);
        } else {
            return response()->json(['message' => 'No user found with this UID and phone. Please register.'], 404);
        }
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
