<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Session;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function SavePackage(Request $request){
        $package=new Package();
        $package->session_id=$request->session_id;
        $package->tracking_number=$request->tracking_number;
        $package->status=$request->status;
        $package->save();

        return redirect()->route('view_session', $request->session_id)
            ->with('success', 'Package created successfully');

    }

    public function UpdatePackage(Request $request,$id){

        $package=Package::find($id);
        if($package) {
            $package->session_id = $request->session_id;
            $package->tracking_number = $request->tracking_number;
            $package->status = $request->status;
            $package->save();

            return redirect()->route('view_session', $request->session_id)
                ->with('success', 'Package updated successfully');
        }
    }

    public function DeletePackage($id){
        $package=Package::find($id);
        if($package){
            $session_id=$package->session_id;
            $package->delete();
            return redirect()->route('view_session',$session_id)->with('success','Session deleted Successfully');
        }
    }

}
