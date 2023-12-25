<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteHome;

class SiteHomeController extends Controller
{
    public function Home(Request $req)
    {
        $h =  SiteHome::firstOrNew(); // Initializing the SiteHome Model

        // Ensure files are present in the request before accessing them
        if ($req->hasFile('cLogo')) {
            $h->companyLogo = $req->file('cLogo')->store('', 'public');
        }

        if ($req->hasFile('bg')) {
            $h->backgroundImage = $req->file('bg')->store('', 'public');
        }

        if($req->filled("welcomeMessage")){
            $h->welcomeMessage = $req->welcomeMessage;
        }

        if($req->filled("slogan")){
            $h->slogan = $req->slogan;
        }

        //$c = SiteHome::Count;

        $saver = $h->save();
        if ($saver) {
            return response()->json(["Result" => "Success"], 200);
        } else {
            return response()->json(["Result" => "Failed"], 500);
        }
    }

    public function GetHome(Request $req){
        return SiteHome::all();
    }










}
