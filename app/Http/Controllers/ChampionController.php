<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Champion;
use App\Models\Authentication;

class ChampionController extends Controller
{
    

    function CreateChampion($userId){
        $s = new Champion();

        $user = Authentication::where('UserId', $userId)->first();
        if($user==null){
            return response()->json(["message"=>"User does not exist"],400);
        }

        $check = Champion::where('UserId', $user->UserId)->first();
        if($check){
            $check->Token = $this->IdGenerator();
            $check->UserId = $user->UserId;
            $check->save();
            return response()->json(["message"=> $check->Token],200);
        }
        else{
            $s->Token = $this->IdGenerator();
            $s->UserId = $user->UserId;
            $s->save();
            return response()->json(["message"=> $s->Token],200);
        }



    }

    function GetChampion($token){
        $Newtoken = $this->IdGenerator();
    
        $user = Champion::where('Token', $token)->first();
    
        if($user == null){
            return response()->json(["message" => "Invalid Token"], 400);
        } else {
            $user->Token = $Newtoken; 
            $user->save();
            return response()->json(["message" => $Newtoken], 200);
        }
    }
    

    function TestChampion($token){
        $user = Champion::where('Token', $token)->get();
        if ($user==null){
            return response()->json(["message"=>"user is null"],400);
        }
        else{
            return response()->json(["message"=>"user"],200);
        }
        
    }





    function IdGenerator(): string {
        $randomID = str_pad(mt_rand(1, 99999999), 5, '0', STR_PAD_LEFT);
        return $randomID;
        }





}
