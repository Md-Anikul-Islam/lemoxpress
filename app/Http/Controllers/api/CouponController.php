<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\CouponUser;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function allCoupon()
    {
        try {
            $coupon = Coupon::latest()->get();
            return response()->json(['coupon' => $coupon], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching data.'], 500);
        }
    }


    public function applyCoupon(Request $request)
    {
        // Validate request
        $request->validate([
            'coupon_id' => 'required|exists:coupons,id',
            'user_id' => 'required|exists:users,id', // Assuming you have a User model
        ]);
        $couponId = $request->coupon_id;
        $userId = $request->user_id;
        // Find the coupon
        $coupon = Coupon::find($couponId);
        if (!$coupon) {
            return response()->json(['message' => 'Coupon not found'], 200);
        }
        // Check if the coupon has expired
        if (Carbon::now()->gt($coupon->valid_to)) {
            return response()->json(['message' => 'Coupon has expired'], 200);
        }
        // Check if the user has reached the maximum usage limit for the coupon
        $userCouponCount = CouponUser::where('coupon_id', $coupon->id)->where('apply_status', 1)
            ->where('user_id', $userId)
            ->count();

        if ($userCouponCount >= $coupon->max_uses) {
            return response()->json(['message' => 'Coupon not valid for you'], 200);
        }else{
            $couponUser = new CouponUser();
            $couponUser->coupon_id = $couponId;
            $couponUser->user_id = $userId;
            $couponUser->save();
            return response()->json(['message' => 'Coupon applied successfully'], 200);
        }
    }


}
