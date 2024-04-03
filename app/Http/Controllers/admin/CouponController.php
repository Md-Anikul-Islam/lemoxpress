<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Toastr;
class CouponController extends Controller
{
    public function index()
    {
        $coupon = Coupon::latest()->get();
        return view('admin.pages.coupon.index',compact('coupon'));
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'code' => 'required|unique:coupons',
                'discount_type' => 'required|in:percentage,fixed_amount',
                'discount_amount' => 'required|numeric|min:0',
                'valid_from' => 'required|date',
                'valid_to' => 'required|date|after:valid_from',
                'max_uses' => 'nullable|integer|min:1',
            ]);


            $coupon = new Coupon();
            $coupon->code = $request->code;
            $coupon->discount_type = $request->discount_type;
            $coupon->discount_amount = $request->discount_amount;
            $coupon->valid_from = $request->valid_from;
            $coupon->valid_to = $request->valid_to;
            $coupon->max_uses = $request->max_uses;
            $coupon->max_amount_to_apply = $request->max_amount_to_apply;
            $coupon->short_note = $request->short_note;

            $coupon->save();
            Toastr::success('Coupon Added Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $coupon = Coupon::findOrFail($id);
            $request->validate([
                'code' => 'required',
                'discount_type' => 'required|in:percentage,fixed_amount',
                'discount_amount' => 'required|numeric|min:0',
                'valid_from' => 'required|date',
                'valid_to' => 'required|date|after:valid_from',
                'max_uses' => 'nullable|integer|min:1',
            ]);

            // Update fleet attributes
            $coupon->code = $request->code;
            $coupon->discount_type = $request->discount_type;
            $coupon->discount_amount = $request->discount_amount;
//            $coupon->valid_from = $request->valid_from;
//            $coupon->valid_to = $request->valid_to;
            $coupon->valid_from = Carbon::parse($request->valid_from)->format('Y-m-d H:i:s'); // Convert to MySQL datetime format
            $coupon->valid_to = Carbon::parse($request->valid_to)->format('Y-m-d H:i:s'); // Convert to MySQL datetime format
            $coupon->max_uses = $request->max_uses;
            $coupon->max_amount_to_apply = $request->max_amount_to_apply;
            $coupon->short_note = $request->short_note;
            $coupon->save();
            Toastr::success('Coupon Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $coupon = Coupon::find($id);
            $coupon->delete();
            Toastr::success('Coupon Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
