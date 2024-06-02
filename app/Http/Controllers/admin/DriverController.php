<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\DriverHistory;
use App\Models\DriverRatting;
use App\Models\TripRequest;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Toastr;
class DriverController extends Controller
{
    public function driverList()
    {
        $driver = Driver::where('status',1)->with('driverHistory')->latest()->get();
        return view('admin.pages.driver.index',compact('driver'));
    }

    public function driverHistpry($id)
    {
        $driverHistpry = DriverHistory::where('did',$id)->latest()->get();
        return view('admin.pages.driver.history',compact('driverHistpry'));
    }


    public function driverTripHistory($id)
    {
        $tripHistory = TripRequest::where('driver_id',$id)->latest()->get();
        return view('admin.pages.driver.tripRequest',compact('tripHistory'));
    }


    public function update(Request $request, $id)
    {

        try {
            $driver = Driver::findOrFail($id);
            $request->validate([
                'status' => 'required',
            ]);

            $driver->status = (int)$request->status;
            $driver->save();
            Toastr::success('Driver Status Updated Successfully', 'Success');
            return redirect()->route('driver.list');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


    public function driverSpecificTripHistory($encryptedId)
    {

        //dd($encryptedId);
        try {
             $id = decrypt($encryptedId);
            //($id);
            $tripRequest = TripRequest::where('id',$id)->with('driver','driver.car')->first();
            //dd($tripRequest);
            return view('trip-verify',compact('tripRequest'));
            return response()->json(['tripRequest' => $tripRequest], 200);
        } catch (DecryptException $e) {
            return response()->json(['error' => 'Invalid encrypted ID'], 400);
        } catch (ModelNotFoundException $e) {

            return response()->json(['error' => 'Trip request not found'], 404);
        }
    }
    //make delete if i delete driver then delete driver, driver history and this driver ratting also
    public function destroy($did)
    {
        try {
            $driver = Driver::findOrFail($did);

            // Delete related DriverHistory and DriverRatting records
            DriverHistory::where('did', $driver->did)->delete();
            DriverRatting::where('did', $driver->did)->delete();
            $driver->delete();
            Toastr::success('Driver  deleted successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function pendingDriverList()
    {
        $driver = Driver::where('status',0)->latest()->get();
        return view('admin.pages.driver.pendingList',compact('driver'));
    }

    public function driverDetails($id)
    {
        $driver = Driver::where('id',$id)->with('driverHistory','car')->first();
        //dd($driver);
        return view('admin.pages.driver.details',compact('driver'));
    }

    public function suspendDriverList()
    {
        $driver = Driver::where('status',2)->latest()->get();
        return view('admin.pages.driver.rejectList',compact('driver'));
    }




}
