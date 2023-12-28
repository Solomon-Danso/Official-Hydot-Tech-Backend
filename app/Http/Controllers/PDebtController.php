<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PDebt;
use Carbon\Carbon;

class PDebtController extends Controller
{
    function CreateDebt(Request $req){
        $s = new PDebt();

        if($req->filled("Section")){
            $s->Section = $req->Section;
        }

        if($req->filled("Debt")){
            $s->Debt = $req->Debt;
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

    function UpdateDebt(Request $req, $Id){
        $s = PDebt::where("id",$Id)->first();

        if($s==null){
            return response()->json(["message"=>"Debt Not Found"],400);
        }

        if($req->filled("Section")){
            $s->Section = $req->Section;
        } 

        if($req->filled("Debt")){
            $s->Debt = $req->Debt;
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

    function GetDebt($Section){

        return PDebt::where("Section", $Section)->get();
    }



    function GetDebtName()
    {
        $topFiveTargets = PDebt::orderBy('Amount', 'desc')->limit(5)->get();
        $targetNames = $topFiveTargets->pluck('Section')->toArray();
    
        return $targetNames;
    }
    
    function GetDebtAmnt()
    {
        $topFiveTargets = PDebt::orderBy('Amount', 'desc')->limit(5)->get();
        $targetNames = $topFiveTargets->pluck('Amount')->toArray();
    
        return $targetNames;
    }
    







    function DeleteDebt($Id){
        $s = PDebt::where("id",$Id);
        if($s==null){
            return response()->json(["message"=>"Debt Not Found"],400);
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
