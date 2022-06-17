<?php

namespace App\Http\Controllers;

use App\Models\License;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LicenseController extends Controller
{   
    public function update(Request $request){
        $this->validate($request, [
            'user_id' => 'required',
            'licenseNo' => 'required',
        ]);
        $user = User::find(request('user_id'));
        $license = $user->license;
        if($license->license_no != request('licenseNo')){
            return response()->json([
                'msg' => 'Invalid or wrong license number!'
            ], 401);
        }
        else if($license->status == true){
            return response()->json([
                'msg' => 'Your license has not expired yet!'
            ], 401);
        }
        else{
            return;
        }
    }

    public function showLicenses(){
        return License::with('user')->latest()->get();
    }
}
