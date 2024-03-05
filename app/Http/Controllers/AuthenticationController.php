<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Authentication;
use Illuminate\Support\Facades\Mail;
use App\Mail\Authentic;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AuthenticationController extends Controller
{
    function SignUp(Request $req, $token){
       
       
        $user = Authentication::where('SToken', $token)->first();
        if($user==null){
            return response()->json(["message"=>"User does not exist"],400);
        }
        
        if($user->SToken = $token && Carbon::now()<=$user->STokenExpire){
    

            $user->UserId = $this->IdGenerator();

            if($req->filled("FullName")){
                $user->FullName = $req->FullName;
            }
    
            if($req->filled("Contact")){
                $user->Contact = $req->Contact;
            }
    
            if($req->filled("Email")){
                $user->Email = $req->Email;
            }
    
            if($req->filled("Role")){
                $user->Role = "SuperAdmin";
            }
    
            if ($req->filled("Password")) {
                $encryptedPassword = bcrypt($req->Password);
                $user->Password = $encryptedPassword;
            }

            if ($req->hasFile('profilePic')) {
                $user->profilePic = $req->file('profilePic')->store('', 'public');
            }

    
            $saver = $user->save();
    
            if ($saver) {
                return response()->json(["Result" => "Success"], 200);
            } else {
                return response()->json(["Result" => "Failed"], 500);
            }
    




        }
        else if( Carbon::now()>$user->STokenExpire){
            return response()->json(["message"=>"Your Token Has Expired"],400);
        }
        else{
            return response()->json(["message"=>`Invalid Token`],400);
        }
        
       
       
       
       
       
       
   

       

    }

 
 
 
 
 
 
 

 
 
    function SignUpToken(){
        $s = Authentication::firstOrNew();
        $s->SToken = $this->IdGenerator();
        $s->STokenExpire = Carbon::now()->addMinutes(10); 

        $saver = $s->save();
        if ($saver) {
            // Send email if the request is successful
            try {
                Mail::to("admin@hydottech.com")->send(new Authentic( $s->SToken));
                return response()->json(['message' => 'Enter Your Verification Token'], 200);
            } catch (\Exception $e) {
              
                return response()->json(['message' => 'Email Request Failed'], 400);
            }
            
   
           
        } else {
            return response()->json(['message' => 'Could not save the Token'], 500);
        }

    }














    public function LogIn(Request $req)
    {
    
        // Use your custom Authentication model to authenticate
        $user = Authentication::where('Email', $req->Email)->first();
    
        if ($user && Hash::check($req->Password, $user->Password)) {
            
            if($user->IsBlocked==true){
                return response()->json(['message' => 'You have exceeded your Login Attempts'], 500);
            }
            else{
                
                $user->Token = $this->IdGenerator();
                $user->TokenExpire = Carbon::now()->addMinutes(10);

                $saver = $user->save();
                if ($saver) {
                    // Send email if the request is successful
                    try {
                        Mail::to($user->Email)->send(new Authentic( $user->Token));
                        return response()->json(['message' => $user->UserId], 200);
                    } catch (\Exception $e) {
                      
                        return response()->json(['message' => 'Email Request Failed'], 400);
                    }
                    
           
                   
                } else {
                    return response()->json(['message' => 'Could not save the Token'], 500);
                }


            }

           
        } else {
            $user->LoginAttempt += 1;

            if($user->LoginAttempt>2){
                $user->IsBlocked=true;

            }
            $user->save();

            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

function Unlocker($email){
    $user = Authentication::where('Email', $email)->first(); 
    if($user==null){
        return response()->json(["message"=>"User does not exist"],400);
    }
    $user->Token = null;
    $user->TokenExpire = null;
    $user->LoginAttempt = 0;
    $user -> IsBlocked = false;

    $saver=  $user -> save();

 if ($saver) {
            return response()->json(["Result" => "Success"], 200);
        } else {
            return response()->json(["Result" => "Failed"], 500);
        }


}




function VerifyToken($userId, $token){
$user = Authentication::where('UserId', $userId)->first();
if($user==null){
    return response()->json(["message"=>"User does not exist"],400);
}

if($user->Token === $token && Carbon::now()<=$user->TokenExpire){
   
   
    $user->Token = null;
    $user->TokenExpire = null;
    $user->LoginAttempt = 0;
    $user -> IsBlocked = false;
    $user -> ServerId = $this->IdGenerator();
   





    $user -> save();

    $c = [
        "FullName" => $user->FullName,
        "UserId" => $user->UserId,
        "profilePic" => $user->profilePic,
        "Role"=> $user->Role,
        "ServerId" => $user -> ServerId,

 ];

    return response()->json(["message" => $c], 200);
}

else if( Carbon::now()>$user->TokenExpire){
    return response()->json(["message"=>"Your Token Has Expired"],400);
}
else{
    return response()->json(["message"=>`Invalid Token`],400);
}




}


function Logout($SeverId){
    $user = Authentication::where('ServerId', $ServerId)->first();
    if($user==null){
        return response()->json(["message"=>"User does not exist"],400);
    }


    $user -> ServerId = null;

    $saver = $user->save();

    if($saver){
        return response()->json(["message"=>"User logged out"],200);
    }
    else{
        return response()->json(["message"=>"Error logging out"],400);
    }


}

function Connection(Request $req){

    $user = Authentication::where('ServerId', $req->ServerId)->first();
    if($user==null){
        return response()->json(["message"=>"User does not exist"],400);
    }

    return response()->json(["message"=>"Bingo"],200);


}



function TokenGenerator(): string {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$^&*()_+{}|<>-=[],.';
        $length = 30;
        $randomString = '';
    
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
    
        return $randomString;
    }



    function IdGenerator(): string {
        $randomID = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
        return $randomID;
        }





}
