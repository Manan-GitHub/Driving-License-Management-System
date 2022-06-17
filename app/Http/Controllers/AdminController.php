<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    // public function index(){
    //     return view('welcome');
    // }

    public function index(Request $request)
    {

        // first check if you are loggedin and admin user ...
        //return Auth::check();
        if (!Auth::check() && $request->path() != 'login') {
            if($request->path() == '/' || $request->path() == '/categories' || $request->path() == '/rules'){
                return view('welcome');
            }
            return redirect('/login');
        }
        return view('welcome');

        // if (!Auth::check() && $request->path() == 'login') {

        //     return view('welcome');
        // }
        // // you are already logged in... so check for if you are an admin user..
        // $user = Auth::user();
        // if ($user->userType == 'User') {
        //     return redirect('/login');
        // }
        // if ($request->path() == 'login') {
        //     return redirect('/');
        // }

        // return $this->checkForPermission($user, $request);
    }

    public function signup(Request $request){
        $this->validate($request, [
            'fullName' => 'required',
            'father_husband_name' => 'required',
            'cnic' => 'required|numeric|min:13|unique:users',
            'age' => 'required',
            'gender' => 'required',
            'city' => 'required',
            'state' => 'required',
            'permanent_address' => 'required',
            'temporary_address' => 'required',
            'email' => 'bail|required|email|unique:users',
            'password' => 'bail|required|min:6',
            'image' => 'required'

        ]);
        $password = bcrypt($request->password);

        $user = User::create([
            'fullName' => request('fullName'),
            'father_husband_name' => request('father_husband_name'),
            'cnic' => request('cnic'),
            'age' => request('age'),
            'gender' => request('gender'),
            'city' => request('city'),
            'state' => request('state'),
            'permanent_address' => request('permanent_address'),
            'temporary_address' => request('temporary_address'),
            'email' => request('email'),
            'password' => $password,
            'image' => request('image'),

        ]);

        return $user;
    }

    public function upload(Request $request){
        $this->validate($request, [
            'file' => 'required|mimes:jpeg,jpg,png',
        ]);
        $picName = time() . '.' . $request->file->extension();
        $request->file->move(public_path('uploads'), $picName);
        return $picName;
    }

    public function login(Request $request)
    {
        // validate request
        $this->validate($request, [
            'email' => 'bail|required|email',
            'password' => 'bail|required',
        ]);

        // Auth
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            return response()->json([
                'msg' => 'You are logged in'
            ]);
        }
        else{
            return response()->json([
                'msg' => 'incorrect login details'
            ], 401);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    // =========================================Users=====================================================

    public function getUser(){
        return User::orderBy('id', 'desc')->get();
    }

    public function deleteUser(Request $request){
        $this->validate($request, [
            'id' => 'required',
        ]);
        return User::where('id', $request->id)->delete();
    }

    public function getUserWithLicense(Request $request){
        return User::where('id', $request->id)->with('license')->get();
    }

    public function updateUser(Request $request){
        // validate request
        $this->validate($request, [
            'email' => 'bail|required|email',
        ]);

        $user = User::find(request('id'));
        if(!Hash::check($request->currentPassword, $user->password)){
            return response()->json([
                'msg' => 'Current Password is incorrect!'
            ], 401);
        }
        else{
            $user->update([
                'email' => $request->email,
                'password' => bcrypt($request->newPassword)
            ]);
            $user->save();
            return;
        }
    }

    public function changePassword(Request $request){
        $this->validate($request, [
            'email' => 'bail|required|email',
        ]);
        if(User::where('email', $request->email)->exists()){
            $user = User::where('email', $request->email)->first();
            $password = Str::random(7);
            $user->password = bcrypt($password);
            $user->save();
            $details = [
                'title' => 'New DLMS Password!',
                'password' => $password
            ];
    
            Mail::to($request->email)->send(new ForgotPassword($details));
        }else{
            return response()->json([
                'msg' => 'Invalid email address. Kindly signup first'
            ], 401);
        }
    }

}

