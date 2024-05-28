<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\CouponUser;
use App\Models\User;
use App\Models\UserHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function storeUser(Request $request)
    {
        try {
            $request->validate([
                'uid' => 'required|unique:users',
                'name' => 'required|string',
                'phone' => 'required|unique:users',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage(), 'errors' => $e->errors()], 200);
        }
        // Check if at least one of phone or email is filled
        if (empty($request->phone) && empty($request->email)) {
            return response()->json(['error' => 'Either phone or email must be filled.'], 200);
        }

        $user = new User();
        $user->uid = $request->uid;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->phone_verification = $request->phone_verification??0;
        $user->profileLink = $request->profileLink??null;
        $user->is_apple = $request->is_apple??0;
        $user->role = 2;
        if ($request->userProfile) {
            $userProfile = time().'.'.$request->userProfile->extension();
            $request->userProfile->move(public_path('images/userProfile'), $userProfile);
            $user->userProfile = $userProfile;
        }
        $user->save();

        // Create the response without the 'is_apple' field
        $responseData = [
            'user' => [
                'uid' => $user->uid,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'phone_verification' => $user->phone_verification,
                'profileLink' => $user->profileLink,
                'role' => $user->role,
                'userProfile' => $user->userProfile,
                'updated_at' => $user->updated_at,
                'created_at' => $user->created_at,
                'id' => $user->id,
            ],
            'message' => 'User Register Success'
        ];
        return response()->json($responseData, 200);

       // return response()->json(['user' => $user,'message' => 'User Register Success'], 200);
    }


//    public function updateUserProfile(Request $request, $id)
//    {
//        try {
//            $validator = Validator::make($request->all(), [
//                'userProfile' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
//            ]);
//            if ($validator->fails()) {
//                throw new ValidationException($validator);
//            }
//            //$user = User::find($id);
//            $user = User::where('uid', $id)->first();
//
//            if (!$user) {
//                return response()->json(['message' => 'User not found'], 404);
//            }
//            // Move and update profile image
//            $profileImage = time() . '.' . $request->userProfile->extension();
//            $request->userProfile->move(public_path('images/userProfile'), $profileImage);
//            $user->userProfile = $profileImage;
//            if ($request->has('userProfile')) {
//                $user->profileLink = url('images/userProfile/' . $profileImage);
//            }
//
//            // Update name if provided
//            if ($request->has('name')) {
//                $user->name = $request->input('name');
//            }
//
//
//            $user->save();
//            $responseData = [
//                'user' => [
//                    'uid' => $user->uid,
//                    'name' => $user->name,
//                    'email' => $user->email,
//                    'phone' => $user->phone,
//                    'phone_verification' => $user->phone_verification,
//                    'profileLink' => $user->profileLink,
//                    'role' => $user->role,
//                    'userProfile' => $user->userProfile,
//                    'updated_at' => $user->updated_at,
//                    'created_at' => $user->created_at,
//                    'id' => $user->id,
//                ],
//                'message' => 'User profile image updated successfully'
//            ];
//            return response()->json(['responseData' => $responseData], 200);
//        } catch (ValidationException $e) {
//            return response()->json(['message' => $e->getMessage(), 'errors' => $e->errors()], 400);
//        } catch (\Exception $e) {
//            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
//        }
//    }

    public function updateUserProfile(Request $request, $id)
    {
        try {
            // Retrieve the user by uid
            $user = User::where('uid', $id)->first();

            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            // Update profile image if provided
            if ($request->hasFile('userProfile')) {
                $validator = Validator::make($request->all(), [
                    'userProfile' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);

                if ($validator->fails()) {
                    throw new ValidationException($validator);
                }

                $profileImage = time() . '.' . $request->userProfile->extension();
                $request->userProfile->move(public_path('images/userProfile'), $profileImage);
                $user->userProfile = $profileImage;
                $user->profileLink = url('images/userProfile/' . $profileImage);
            }

            // Update name if provided
            if ($request->has('name')) {
                $user->name = $request->input('name');
            }

            $user->save();

            $responseData = [
                'user' => [
                    'uid' => $user->uid,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'phone_verification' => $user->phone_verification,
                    'profileLink' => $user->profileLink,
                    'role' => $user->role,
                    'userProfile' => $user->userProfile,
                    'updated_at' => $user->updated_at,
                    'created_at' => $user->created_at,
                    'id' => $user->id,
                ],
                'message' => 'User profile updated successfully'
            ];

            return response()->json(['responseData' => $responseData], 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage(), 'errors' => $e->errors()], 400);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }


    public function loginUser(Request $request)
    {
//        $request->validate([
//            'phone' => 'nullable',
//            'email' => 'nullable',
//        ], [
//            'phone.required_without' => 'Please provide either phone or email.',
//            'email.required_without' => 'Please provide either phone or email.',
//        ]);
//
//        // Check if both phone and email are not provided
//        if (!$request->filled('phone') && !$request->filled('email')) {
//            return response()->json(['message' => 'Please provide either phone or email.'], 200);
//        }

        $request->validate([
            'credential' => 'required', // Change 'phone' to 'identifier'

        ]);

        //dd($request->all());

//        if($request->is_apple == 1){
//            $user = User::where('phone', $request->credential)
//                ->orWhere('email', $request->credential)
//                ->first();
//        }elseif ($request->is_apple == 0){
//            $user = User::where('phone', $request->credential)
//                ->orWhere('email', $request->credential)
//                ->first();
//        }



        if ($request->is_apple == 1) {
            $user = User::where(function ($query) use ($request) {
                $query->where('phone', $request->credential)
                    ->orWhere('email', $request->credential);
            })
                ->where('is_apple', 1)
                ->first();
        } elseif ($request->is_apple == 0) {
            $user = User::where(function ($query) use ($request) {
                $query->where('phone', $request->credential)
                    ->orWhere('email', $request->credential);
            })
                ->where('is_apple', 0)
                ->first();
        }
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
                'phoneVerification' => $user->phone_verification,
                'profileLink' => $user->profileLink,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ];
            return response()->json(['user' => $userData,'message' => 'User Found'], 200);
        } else {
            return response()->json(['message' => 'No user found with this UID and phone. Please register.'], 200);
        }
    }


    public function storeUserHistory(Request $request)
    {
        $request->validate([
            'uid' => 'required',
            'user_id' => 'required',
            'did' => 'required',
            'origin_address' => 'required',
            'destination_address' => 'required',
            'time' => 'required',
            'total_fare' => 'required',
        ]);
        $user = new UserHistory();
        $user->uid = $request->uid;
        $user->user_id= $request->user_id;
        $user->did= $request->did;
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
        return response()->json(['history' => $user], 200);
    }


    public function getUserHistory($id)
    {
        $userHistory = UserHistory::where('uid',$id)->with('driver','driver.car')->latest()->get();
        return response()->json(['userHistory' => $userHistory], 200);
    }

    public function deleteUser(Request $request)
    {
        $request->validate([
            'uid' => 'required',
        ]);
        $user = User::where('uid', $request->uid)->first();
        if ($user) {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'No user found with this UID.'], 200);
        }
    }

    public function getUserProfile($id)
    {
        $user = User::where('uid',$id)->first();
        if ($user) {
            return response()->json(['user' => $user], 200);
        } else {
            return response()->json(['message' => 'No user found with this ID.'], 200);
        }
    }



}
