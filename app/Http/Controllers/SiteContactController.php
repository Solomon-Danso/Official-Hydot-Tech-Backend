<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteContact;

class SiteContactController extends Controller
{
    function Contact(Request $req){
        $s = SiteContact::firstOrNew();
       
        if($req->filled("Clients")){
            $s->Clients = $req->Clients;
        }

        if($req->filled("Staffs")){
            $s->Staffs = $req->Staffs;
        }

        if($req->filled("Projects")){
            $s->Projects = $req->Projects;
        }

        if($req->filled("Phone")){
            $s->Phone = $req->Phone;
        }

        if($req->filled("Email")){
            $s->Email = $req->Email;
        }

       $Saver= $s->save();
       if($Saver){

        return response()->json(["Return"=>"Success"],200);
       }
       else{
        return response()->json(["Return"=>"Failed"],400);
       }

    }


function GetContact(){
    return SiteContact::all();
}







}











