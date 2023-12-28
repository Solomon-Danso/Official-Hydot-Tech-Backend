<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PAsset;
use Carbon\Carbon;

class PAssetController extends Controller
{
    function CreateAsset(Request $req){
        $s = new PAsset();

        if($req->filled("Section")){
            $s->Section = $req->Section;
        }

        if($req->filled("Asset")){
            $s->Asset = $req->Asset;
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

    function UpdateAsset(Request $req, $Id){
        $s = PAsset::where("id",$Id)->first();

        if($s==null){
            return response()->json(["message"=>"Asset Not Found"],400);
        }

        if($req->filled("Section")){
            $s->Section = $req->Section;
        } 

        if($req->filled("Asset")){
            $s->Asset = $req->Asset;
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



    function GetAssetName()
{
    $topFiveTargets = PAsset::orderBy('Amount', 'desc')->limit(5)->get();
    $targetNames = $topFiveTargets->pluck('Section')->toArray();

    return $targetNames;
}

function GetAssetAmnt()
{
    $topFiveTargets = PAsset::orderBy('Amount', 'desc')->limit(5)->get();
    $targetNames = $topFiveTargets->pluck('Amount')->toArray();

    return $targetNames;
}





    function GetAsset($Section){

        return PAsset::where("Section", $Section)->get();
    }

    function DeleteAsset($Id){
        $s = PAsset::where("id",$Id);
        if($s==null){
            return response()->json(["message"=>"Asset Not Found"],400);
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
