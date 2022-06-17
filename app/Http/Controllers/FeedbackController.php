<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    
    public function index(){
        $feedbacks =  Feedback::orderBy('id', 'desc')->with('user')->get();
        return $feedbacks;
    }
    
    public function create(Request $request){
       Feedback::create([
            'user_id' => request('user_id'),
            'content' => request('content')
        ]);

        return;
    }

    public function delete(Request $request){
        $this->validate($request, [
            'id' => 'required',
        ]);
        return Feedback::where('id', $request->id)->delete();
    }
}
