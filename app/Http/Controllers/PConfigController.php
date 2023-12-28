<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PConfig;
use Carbon\Carbon;

class PConfigController extends Controller
{
    function CreateConfig(Request $req){
        $s = new PConfig();

        if($req->filled("Section")){
            $s->Section = $req->Section;
        }

        if($req->filled("Config")){
            $s->Config = $req->Config;
        }

        if($req->filled("Percentage")){
            $s->Percentage = $req->Percentage;
        }

        if($req->filled("TheDate")){
            $s->TheDate = Carbon::parse($req->TheDate)->format('Y-m-d H:i:s');
        }
        $s->Status = "Ongoing";

        
        $c = PConfig::where('Section', $req->Section)->first();
        if($c){
            if($req->filled("Section")){
                $c->Section = $req->Section;
            }
    
            if($req->filled("Config")){
                $c->Config = $req->Config;
            }
    
            if($req->filled("Percentage")){
                $c->Percentage = $req->Percentage;
            }
    
            if($req->filled("TheDate")){
                $c->TheDate = Carbon::parse($req->TheDate)->format('Y-m-d H:i:s');
            }

            $saver = $c->save();
            if($saver){
                return response()->json(["message"=>"Successfully saved"],200);
            }
            else{
                return response()->json(["message"=>"An error has occured"],400);
            }
    

        }
        else{


            $saver = $s->save();
            if($saver){
                return response()->json(["message"=>"Successfully saved"],200);
            }
            else{
                return response()->json(["message"=>"An error has occured"],400);
            }
    

        }


    }

    function UpdateConfig(Request $req, $Id){
        $s = PConfig::where("id",$Id)->first();

        if($s==null){
            return response()->json(["message"=>"Config Not Found"],400);
        }

        if($req->filled("Section")){
            $s->Section = $req->Section;
        } 

        if($req->filled("Config")){
            $s->Config = $req->Config;
        }

        if($req->filled("Percentage")){
            $s->Percentage = $req->Percentage;
        }

        if($req->filled("StartDate")){
            $s->StartDate = $req->StartDate;
        }

        if($req->filled("Status")){
            $s->Status = $req->Status;
        }

        $saver = $s->save();
        if($saver){
            return response()->json(["message"=>"Successfully saved"],200);
        }
        else{
            return response()->json(["message"=>"An error has occured"],400);
        }



    }

    function GetConfig($Section){

        return PConfig::where("Section", $Section)->get();
    }

    function GetConfigD() {
        $grouped = PConfig::all();
            return $grouped;
                        
            }
    
    
    

    function DeleteConfig($Id){
        $s = PConfig::where("id",$Id);
        if($s==null){
            return response()->json(["message"=>"Config Not Found"],400);
        }

        $saver = $s->delete();
        if($saver){
            return response()->json(["message"=>"Successfully deleted"],200);
        }
        else{
            return response()->json(["message"=>"An error has occured"],400);
        }

    }

}
