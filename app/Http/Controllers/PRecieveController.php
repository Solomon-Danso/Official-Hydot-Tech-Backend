<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PRecieve;
use Carbon\Carbon;

class PRecieveController extends Controller
{
    function CreateRecieve(Request $req){
        $s = new PRecieve();

        if($req->filled("Section")){
            $s->Section = $req->Section;
        }

        if($req->filled("Recieve")){
            $s->Recieve = $req->Recieve;
        }

        if($req->filled("Amount")){
            $s->Amount = $req->Amount;
        }

        if($req->filled("TheDate")){
            $s->TheDate = Carbon::parse($req->TheDate)->format('Y-m-d H:i:s');
        }
        $s->Status = "Ongoing";

        $saver = $s->save();
        if($saver){
            return response()->json(["message"=>"Successfully saved"],200);
        }
        else{
            return response()->json(["message"=>"An error has occured"],400);
        }



    }

    function UpdateRecieve(Request $req, $Id){
        $s = PRecieve::where("id",$Id)->first();

        if($s==null){
            return response()->json(["message"=>"Recieve Not Found"],400);
        }

        if($req->filled("Section")){
            $s->Section = $req->Section;
        } 

        if($req->filled("Recieve")){
            $s->Recieve = $req->Recieve;
        }

        if($req->filled("Amount")){
            $s->Amount = $req->Amount;
        }

        if($req->filled("TheDate")){
            $s->TheDate = $req->TheDate;
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

    function GetRecieve($Section){

        return PRecieve::where("Section", $Section)->get();
    }


    function GetRecieveName()
    {
        $sources = PRecieve::all();
        $sectionArray = $sources->pluck('Section')->toArray();
    
        return $sectionArray;
    }

    function GetRecieveAmnt()
    {
        $sources = PRecieve::all();
        $sectionArray = $sources->pluck('Amount')->toArray();
    
        return $sectionArray;
    }




    function DeleteRecieve($Id){
        $s = PRecieve::where("id",$Id);
        if($s==null){
            return response()->json(["message"=>"Recieve Not Found"],400);
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
