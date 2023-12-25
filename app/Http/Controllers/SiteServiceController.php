<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteService;

class SiteServiceController extends Controller
{
    public function Service(Request $req)
    {
        $s = SiteService::firstOrNew();
        
        if ($req->filled('Web')) {
            $s->Web = $req->Web;
        }

        if ($req->filled('Soft')) {
            $s->Soft = $req->Soft;
        }


        if ($req->filled('ERP')) {
            $s->ERP = $req->ERP;
        }


       $saver= $s->save();
       if ($saver) {
        return response()->json(["Result" => "Success"], 200);
    } else {
        return response()->json(["Result" => "Failed"], 500);
    }

    }


    public function GetService(Request $req){
        return SiteService::all();
    }





}
