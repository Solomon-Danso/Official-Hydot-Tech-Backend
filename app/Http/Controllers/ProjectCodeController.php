<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectCode;
use App\Models\PaymentConfiguration;
use App\Models\PaymentHistory;


class ProjectCodeController extends Controller
{
    function CreateProject(Request $req){
        $p = new ProjectCode();

        if($req->filled("Name")){
            $p->Name = $req->Name;
        }

        if($req->filled("Description")){
            $p->Description = $req->Description;
        }

        if($req->filled("Industry")){
            $p->Industry = $req->Industry;
        }

        
            $p->Status = "Ongoing";
        

        if($req->filled("Section")){
            $p->Section = $req->Section;
        }

        if ($req->hasFile('SourceCode')) {
            $p->SourceCode = $req->file('SourceCode')->store('', 'public');
        }

        $saver = $p->save();
        if($saver){
            return response()->json(["message"=>"The project has been saved"],200);
        }
        else{
            return response()->json(["message"=>"Couldnot save the project"],400);
        }


    }
    function UpdateProject(Request $req,$id){
        $p = ProjectCode::where("id",$id)->first();
        if(!$p){
            return response()->json(["message"=>"Project not found"],400);
        }


        if($req->filled("Name")){
            $p->Name = $req->Name;
        }

        if($req->filled("Description")){
            $p->Description = $req->Description;
        }

        if($req->filled("Industry")){
            $p->Industry = $req->Industry;
        }

        if($req->filled("Status")){
            $p->Status = $req->Status;
        }

        if($req->filled("Section")){
            $p->Section = $req->Section;
        }

        if ($req->hasFile('SourceCode')) {
            $p->SourceCode = $req->file('SourceCode')->store('', 'public');
        }

        $saver = $p->save();
        if($saver){
            return response()->json(["message"=>"The project has been saved"],200);
        }
        else{
            return response()->json(["message"=>"Couldnot save the project"],400);
        }


    }

    function DeleteProject($id){
        $p = ProjectCode::where("id",$id)->first();
        if(!$p){
            return response()->json(["message"=>"Project not found"],400);
        }
       
        $saver =  $p->delete();

        if($saver){
            return response()->json(["message"=>"Project deleted Success"],200);
        }
        else{
            return response()->json(["message"=>"Project deleted Fail"],200);
        }
        

}

    function AllProject(){
       return ProjectCode::all(); 
    }

    function CountAllProject(){
        return ProjectCode::count(); 
     }

     function SumAllClients(){
        return PaymentConfiguration::sum("ActiveUsers"); 
     }

     function SumAllPayment(){
        return PaymentHistory::sum("Amount"); 
     }

     function TopFiveMostViewedValue()
     {
         $topFiveTargets = PaymentConfiguration::orderBy('ActiveUsers', 'desc')->limit(5)->get();
         $targetNames = $topFiveTargets->pluck('ActiveUsers')->toArray();
     
         return $targetNames;
     }
   
   
     function TopFiveMostViewedName()
    {
        $topFiveTargets = PaymentConfiguration::orderBy('ActiveUsers', 'desc')->limit(5)->get();
        $targetNames = $topFiveTargets->pluck('ProductName')->toArray();
    
        return $targetNames;
    }


    function TopFiveMostPayedValue()
    {
        $topFiveCompanies = PaymentHistory::selectRaw('CompanyId, CompanyName, sum(Amount) as total_amount')
            ->groupBy('CompanyId', 'CompanyName')
            ->orderByDesc('total_amount')
            ->take(5)
            ->get();
    
        $companiesData = $topFiveCompanies->map(function ($company) {
            return [
               
                $company->total_amount,
            ];
        })->toArray();
    
        return $companiesData;
    }

    function TopFiveMostPayedName()
    {
        $topFiveCompanies = PaymentHistory::selectRaw('CompanyId, CompanyName, sum(Amount) as total_amount')
            ->groupBy('CompanyId', 'CompanyName')
            ->orderByDesc('total_amount')
            ->take(5)
            ->get();
    
        $companiesData = $topFiveCompanies->map(function ($company) {
            return [
                $company->CompanyName,
               
            ];
        })->toArray();
    
        return $companiesData;
    }
    




}
