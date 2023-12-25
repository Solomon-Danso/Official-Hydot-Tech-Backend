<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteAbout;

class SiteAboutController extends Controller
{
    public function About(Request $req)
{
    $s = SiteAbout::firstOrNew();

    if ($req->filled('HydotTech')) {
        $s->HydotTech = $req->HydotTech;
    }

    if ($req->filled('Vision')) {
        $s->Vision = $req->Vision;
    }


    if ($req->filled('Mission')) {
        $s->Mission = $req->Mission;
    }


    if ($req->hasFile('aLogo')) {
        $s->Image = $req->file('aLogo')->store('', 'public');
    }

   $saver= $s->save();
   if ($saver) {
    return response()->json(["Result" => "Success"], 200);
} else {
    return response()->json(["Result" => "Failed"], 500);
}

}

public function GetAbout(){
    return SiteAbout::all();
}


}
