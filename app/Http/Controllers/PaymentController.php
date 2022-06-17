<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function applicationPayment(Request $request){
        $matchThese = ['user_id' => $request->userId, 'status' => 'unprocessed'];
        if(Application::where($matchThese)->first())
        $application = Application::where($matchThese)->first();
        $application->payment_status = true;
        $application->save();
        return redirect('/');
    }

    public function renewalPayment(Request $request){
        $user = User::find(request('userId'));
        $license = $user->license;
        $license->status = true;
        $license->expiry_date = Carbon::now()->addYears(3);
        $license->save();
        return redirect('/');
    }
}
