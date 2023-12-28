<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PJob;
use Carbon\Carbon;

class PJobController extends Controller
{
    function CreateJob(Request $req){
        $s = new PJob();

        if($req->filled("Section")){
            $s->Section = $req->Section;
        }

        if($req->filled("Job")){
            $s->Job = $req->Job;
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

    function UpdateJob(Request $req, $Id){
        $s = PJob::where("id",$Id)->first();

        if($s==null){
            return response()->json(["message"=>"Job Not Found"],400);
        }

        if($req->filled("Section")){
            $s->Section = $req->Section;
        } 

        if($req->filled("Job")){
            $s->Job = $req->Job;
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



    function GetJobName()
    {
        $topFiveTargets = PJob::orderBy('Amount', 'desc')->limit(5)->get();
        $targetNames = $topFiveTargets->pluck('Section')->toArray();
    
        return $targetNames;
    }
    
    function GetJobAmnt()
    {
        $topFiveTargets = PJob::orderBy('Amount', 'desc')->limit(5)->get();
        $targetNames = $topFiveTargets->pluck('Amount')->toArray();
    
        return $targetNames;
    }





    function GetJob($Section){

        return PJob::where("Section", $Section)->get();
    }

    function DeleteJob($Id){
        $s = PJob::where("id",$Id);
        if($s==null){
            return response()->json(["message"=>"Job Not Found"],400);
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
