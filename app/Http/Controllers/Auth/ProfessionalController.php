<?php

namespace App\Http\Controllers\Auth;

use App\Mail\SendCodeMail;
use App\Models\Professional;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Professionals\LoginProfesLogin;
use App\Http\Requests\Professionals\RegisterProfesRequest;

class ProfessionalController extends Controller
{
    // Function for sign up 
    public function register(RegisterProfesRequest $request){
        $professional = new Professional();
        $professional->full_name = $request->full_name;
        $professional->gender = $request->gender;
        $professional->email = $request->email;
        $professional->phone = $request->phone;
        $professional->city = $request->city;
        $professional->address = $request->address;
        $professional->password = Hash::make($request->password);
        $professional->code = rand(100000,999999);
        $professional->save();
        $token = $professional->createToken('professional-token')->plainTextToken;
        try {
            Mail::to($professional->email)->send(new SendCodeMail($professional->full_name, $professional->code));
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Failed to send email', 'error' => $e->getMessage()], 500);
        }
        return response()->json(['status'=>true,'message'=>'Verify Your Email Address' ,'professional'=>$professional, 'token'=>$token],200);
    }

    //Function for sign in 
    public function login(LoginProfesLogin $request){
        $professional = Professional::where('email',$request->email)->first();
        if(!Hash::check($request->password,$professional->password)){
            return response()->json(['message'=>'Incorrect Password'],401);
        }
        $token = $professional->createToken('professional-token')->plainTextToken;
        return response()->json(['status'=>true, 'professional'=>$professional, 'token'=>$token],200);
    }

    //Function for update the profile  
    public function update(Request $request){

    }

    //Function for log out
    public function logout(Request $request){
        
    }
}
