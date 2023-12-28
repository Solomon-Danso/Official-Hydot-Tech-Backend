<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PTarget;
use Carbon\Carbon;

class PTargetController extends Controller
{
    function CreateTarget(Request $req){
        $s = new PTarget();

        if($req->filled("Section")){
            $s->Section = $req->Section;
        }

        if($req->filled("Target")){
            $s->Target = $req->Target;
        }

        if($req->filled("Amount")){
            $s->Amount = $req->Amount;
        }

        if($req->filled("Deadline")){
            $s->Deadline = Carbon::parse($req->Deadline)->format('Y-m-d H:i:s');
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

    function UpdateTarget(Request $req, $Id){
        $s = PTarget::where("id",$Id)->first();

        if($s==null){
            return response()->json(["message"=>"Target Not Found"],400);
        }

        if($req->filled("Section")){
            $s->Section = $req->Section;
        }

        if($req->filled("Target")){
            $s->Target = $req->Target;
        }

        if($req->filled("Amount")){
            $s->Amount = $req->Amount;
        }

        if($req->filled("Deadline")){
            $s->Deadline = $req->Deadline;
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

    function GetTarget($Section){

        return PTarget::where("Section", $Section)->get();
    }

    function DeleteTarget($Id){
        $s = PTarget::where("id",$Id);
        if($s==null){
            return response()->json(["message"=>"Target Not Found"],400);
        }

        $saver = $s->delete();
        if($saver){
            return response()->json(["message"=>"Successfully deleted"],200);
        }
        else{
            return response()->json(["message"=>"An error has occured"],400);
        }

    }

    function GetTargetName()
    {
        $sources = PTarget::all();
        $sectionArray = $sources->pluck('Section')->toArray();
    
        return $sectionArray;
    }

    function GetTargetAmnt()
    {
        $sources = PTarget::all();
        $sectionArray = $sources->pluck('Amount')->toArray();
    
        return $sectionArray;
    }

}
