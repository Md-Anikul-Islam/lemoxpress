<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Toll;
use Illuminate\Http\Request;
use Toastr;
class TollController extends Controller
{
    public function index()
    {
        $toll = Toll::latest()->get();
        return view('admin.pages.toll.index',compact('toll'));
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'amount' => 'required',
            ]);
            $toll = new Toll();
            $toll->name = $request->name;
            $toll->latitude = $request->latitude;
            $toll->longitude = $request->longitude;
            $toll->amount = $request->amount;
            $toll->save();
            Toastr::success('Toll Added Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $toll = Toll::findOrFail($id);
            $request->validate([
                'name' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'amount' => 'required',
            ]);
            $toll->name = $request->name;
            $toll->latitude = $request->latitude;
            $toll->longitude = $request->longitude;
            $toll->amount = $request->amount;
            $toll->save();
            Toastr::success('Toll Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $toll = Toll::find($id);
            $toll->delete();
            Toastr::success('Toll Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
