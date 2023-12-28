<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PSource;
use Carbon\Carbon;

class PSourceController extends Controller
{
    function CreateSource(Request $req){
        $s = new PSource();

        if($req->filled("Section")){
            $s->Section = $req->Section;
        }

        if($req->filled("Source")){
            $s->Source = $req->Source;
        }

        if($req->filled("Amount")){
            $s->Amount = $req->Amount;
        }

        if($req->filled("StartDate")){
            $s->StartDate = Carbon::parse($req->StartDate)->format('Y-m-d H:i:s');
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

    function UpdateSource(Request $req, $Id){
        $s = PSource::where("id",$Id)->first();

        if($s==null){
            return response()->json(["message"=>"Source Not Found"],400);
        }

        if($req->filled("Section")){
            $s->Section = $req->Section;
        } 

        if($req->filled("Source")){
            $s->Source = $req->Source;
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

    function GetSource($Section){

        return PSource::where("Section", $Section)->get();
    }

    function GetSourceName()
    {
        $sources = PSource::all();
        $sectionArray = $sources->pluck('Section')->toArray();
    
        return $sectionArray;
    }

    function GetSourceAmnt()
    {
        $sources = PSource::all();
        $sectionArray = $sources->pluck('Amount')->toArray();
    
        return $sectionArray;
    }
    

   

    function DeleteSource($Id){
        $s = PSource::where("id",$Id);
        if($s==null){
            return response()->json(["message"=>"Source Not Found"],400);
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
