<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\CouponUser;
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
        return response()->json(['user' => $user,'message' => 'User Register Success'], 200);
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
            'user_id' => 'required',
            'driver_id' => 'required',
            'origin_address' => 'required',
            'destination_address' => 'required',
            'time' => 'required',
            'total_fare' => 'required',
        ]);


        $user = new UserHistory();
        $user->uid = $request->uid;
        $user->user_id= $request->user_id;
        $user->driver_id= $request->driver_id;
        $user->origin_address = $request->origin_address;
        $user->destination_address = $request->destination_address;
        $user->total_fare = $request->total_fare;
        $user->time = $request->time;
        $user->save();

        // Update apply_status for the latest created CouponUser entry for the same user_id
        $latestCouponUser = CouponUser::where('user_id', $request->user_id)
            ->latest('created_at')
            ->first();

        //dd($latestCouponUser);

        if ($latestCouponUser) {
            $latestCouponUser->update(['apply_status' => 1]);
        }



        return response()->json(['history' => $user], 201);
    }



}
