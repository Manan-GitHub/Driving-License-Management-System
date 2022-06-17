<?php

namespace App\Http\Controllers;

use App\Mail\ApproveMail;
use App\Mail\DisapproveMail;
use App\Models\Application;
use App\Models\License;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session as FacadesSession;

class ApplicationController extends Controller
{
    //
    public function create(Request $request){
        $this->validate($request, [
            'license_type' => 'required',
            'medical_certificate' => 'required',
        ]);

        $user = User::find(request('user_id'));
        if($user->isLicensed == true){
            if($user->license->license_type == request('license_type')){
                return response()->json([
                    'msg' => 'You already have this type of license!'
                ], 401);
            }
        }
        $user->hasApplied = true;
        $user->save();

        $applicationNumber = $user->cnic + rand(10, 99);

        $application = Application::create([
            'user_id' => request('user_id'),
            'application_No' => $applicationNumber,
            'license_type' => request('license_type'),
            'medical_certificate' => request('medical_certificate'),
        ]);

        return $application;
        
    }

    public function showApplications(){
        $matchThese = [
            'status' => 'unprocessed',
            'payment_status' => true
        ];
        return Application::where($matchThese)->with('user')->get();
    }

    public function showProcessedApplications(){
        return Application::where('status', '!=', 'unprocessed')->with('user')->latest()->get();
    }

    public function disapprove(Request $request){
        $application = Application::find(request('id'));
        $application->status = 'disapproved';
        $application->save();
        $user = $application->user;
        $user->hasApplied = false;
        $user->save();

        $details = [
            'title' => 'Application Disapproved!',
            'body' => 'Depending upon the results of your driving test, we are sorry to inform you that you have failed the driving test. Better luck next time'
        ];

        Mail::to($application->user->email)->send(new DisapproveMail($details));

        return response()->json([
            'msg' => 'Email sent'
        ]);
    }

    public function approve(Request $request){
        $application = Application::find(request('id'));
        $application->status = 'approved';
        $application->save();
        $user = $application->user;
        $user->hasApplied = false;
        
        if($user->isLicensed == true){
            $user->license->delete();
        }

        //Issuing license
        $licenseNo = $this->generateLicenseNo(6) . strval($user->id);
        License::create([
            'user_id' => $user->id,
            'license_no' => $licenseNo,
            'license_type' => $application->license_type,
            'status' => true,
            'expiry_date' => Carbon::now()->addYears(3)
        ]);
        $user->isLicensed = true;
        $user->save();
        $details = [
            'title' => 'Congratulations!',
            'body' => 'You have successfully passed the driving license test. You must pay the required fee depending upon the license type to get your license issued'
        ];

        Mail::to($application->user->email)->send(new ApproveMail($details));

        return response()->json([
            'msg' => 'Email sent'
        ]);
    }
    
    public function generateLicenseNo($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    
}
