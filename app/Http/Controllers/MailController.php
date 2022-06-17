<?php

namespace App\Http\Controllers;

use App\Mail\dlmsMail;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function callEmail(Request $request){
        $application = Application::find(request('id'));
        $application->email_sent = true;
        $application->save();
        $details = [
            'title' => 'Congratulations!',
            'body' => 'Your application has been approved and you are required to arrive at our test center for the driving test tomorrow at 10:00 AM'
        ];

        Mail::to($application->user->email)->send(new dlmsMail($details));

        return response()->json([
            'msg' => 'Email sent'
        ]);
    }
}
