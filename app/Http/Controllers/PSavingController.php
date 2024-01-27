<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PSaving;
use Carbon\Carbon;

class PSavingController extends Controller
{
    function CreateSaving(Request $req){
        $s = new PSaving();

        if($req->filled("Section")){
            $s->Section = $req->Section;
        }

        if($req->filled("Saving")){
            $s->Saving = $req->Saving;
        }

        if($req->filled("Amount")){
            $s->Amount = $req->Amount;
        }

        if($req->filled("TheDate")){
            $s->TheDate = Carbon::parse($req->TheDate)->format('Y-m-d H:i:s');
        }
        $s->Status = "Ongoing";

        
        $c = PSaving::where('Section', $req->Section)->first();
        if($c){
            
    
            if($req->filled("Saving")){
                $c->Saving = $req->Saving;
            }
    
            if($req->filled("Amount")){
                $c->Amount = $c->Amount+$req->Amount;
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

    function UpdateSaving(Request $req, $Id){
        $s = PSaving::where("id",$Id)->first();

        if($s==null){
            return response()->json(["message"=>"Saving Not Found"],400);
        }

        if($req->filled("Section")){
            $s->Section = $req->Section;
        } 

        if($req->filled("Saving")){
            $s->Saving = $req->Saving;
        }

        if($req->filled("Amount")){
            $s->Amount = $req->Amount;
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

    function GetSaving($Section){

        return PSaving::where("Section", $Section)->get();
    }

    function GetSavingD() {
        $grouped = PSaving::all();
            return $grouped;
                        
            }
    
    
    

    function DeleteSaving($Id){
        $s = PSaving::where("id",$Id);
        if($s==null){
            return response()->json(["message"=>"Saving Not Found"],400);
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
