<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PStrategy;
use Carbon\Carbon;

class PStrategyController extends Controller
{
    function CreateStrategy(Request $req){
        $s = new PStrategy();

        if($req->filled("Section")){
            $s->Section = $req->Section;
        }

        if($req->filled("Target")){
            $s->Target = $req->Target;
        }

        if($req->filled("Amount")){
            $s->Amount = $req->Amount;
        }

        if($req->filled("Description")){
            $s->Description = $req->Description;
        }

        if($req->filled("Deadline")){
            $s->Deadline = Carbon::parse($req->Deadline)->format('Y-m-d H:i:s');
        }
        $s->Statuz = "Ongoing";

        $saver = $s->save();
        if($saver){
            return response()->json(["message"=>"Successfully saved"],200);
        }
        else{
            return response()->json(["message"=>"An error has occured"],400);
        }



    }

    function UpdateStrategy(Request $req, $Id){
        $s = PStrategy::where("id",$Id)->first();

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

        if($req->filled("Statuz")){
            $s->Statuz = $req->Statuz;
        }

        if($req->filled("Description")){
            $s->Description = $req->Description;
        }

        $saver = $s->save();
        if($saver){
            return response()->json(["message"=>"Successfully saved"],200);
        }
        else{
            return response()->json(["message"=>"An error has occured"],400);
        }



    }

    function GetStrategy($Section){

        return PStrategy::where("Section", $Section)->get();
    }

    function DeleteStrategy($Id){
        $s = PStrategy::where("id",$Id);
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

}
