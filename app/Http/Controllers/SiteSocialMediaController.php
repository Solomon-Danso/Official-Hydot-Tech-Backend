<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteSocialMedia;

class SiteSocialMediaController extends Controller
{
    
    public function Social(Request $req)
    {
        $s = new SiteSocialMedia;
    
        $s->Link = $req->Link;

        if ($req->hasFile('Logo')) {
            $s->Logo = $req->file('Logo')->store('', 'public');
        }
    
       $saver= $s->save();
       if ($saver) {
        return response()->json(["Result" => "Success"], 200);
    } else {
        return response()->json(["Result" => "Failed"], 500);
    }
    
    }
    
    public function GetMedia(){
        return SiteSocialMedia::all();
    }

    public function DeleteMedia($Id){
        $s = SiteSocialMedia::find($Id);

        if($s==null){
            return response()->json(["Result" => "Failed"], 500);
        }

        $saver= $s->delete();

        if ($saver) {
            return response()->json(["Result" => "Success"], 200);
        } else {
            return response()->json(["Result" => "Failed"], 500);
        }
        

    }
    

}
