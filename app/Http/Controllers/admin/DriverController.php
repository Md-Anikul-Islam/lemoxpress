<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\DriverHistory;
use App\Models\TripRequest;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Toastr;
class DriverController extends Controller
{
    public function driverList()
    {
        $driver = Driver::with('driverHistory')->latest()->get();
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
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

//    public function driverSpecificTripHistory($id)
//    {
//        $tripHistory = TripRequest::where('id',$id)->latest()->get();
//        dd($tripHistory);
//        return view('admin.pages.driver.tripRequest',compact('tripHistory'));
//    }

    public function driverSpecificTripHistory($encryptedId)
    {
        try {
            $id = decrypt($encryptedId); // Decrypt the encrypted ID
            // Use the decrypted ID to fetch the corresponding data
            $tripRequest = TripRequest::where('id',$id)->with('driver','driver.car')->latest()->get();
            // Return the data as needed
            return response()->json(['tripRequest' => $tripRequest], 200);
        } catch (DecryptException $e) {
            // Handle decryption error
            return response()->json(['error' => 'Invalid encrypted ID'], 400);
        } catch (ModelNotFoundException $e) {
            // Handle model not found error
            return response()->json(['error' => 'Trip request not found'], 404);
        }
    }


}
