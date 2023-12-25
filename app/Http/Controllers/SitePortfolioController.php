<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SitePortfolio;

class SitePortfolioController extends Controller
{

    public function Portfolio(Request $req)
    {
        $s = new SitePortfolio;

        if ($req->hasFile('Background')) {
            $s->Background = $req->file('Background')->store('', 'public');
        }

        if ($req->hasFile('Document')) {
            $s->Document = $req->file('Document')->store('', 'public');
        }

        $s->ProductId = $this->IdGenerator();
        $s->Section = $req->Section;
        $s->Title = $req->Title;
        $s->Link = $req->Link;


       $saver= $s->save();
       if ($saver) {
        return response()->json(["Result" => "Success"], 200);
    } else {
        return response()->json(["Result" => "Failed"], 500);
    }

    }


    function GetAllProducts(){
        return SitePortfolio::all();
    }

    function GetSingleProduct($PrdId){
        $s = SitePortfolio::where("ProductId",$PrdId)->first();

        if($s==null){
            return response()->json(["Result" => "Product Does Not Exist"], 500);
        }

        $s->Views = $s->Views+1;

        $saver= $s->save();
       if ($saver) {
        return $s;
    } else {
        return response()->json(["Result" => "Failed"], 500);
    }


    }

    public function UpdateProduct(Request $req, $PrdId)
    {
        $s = SitePortfolio::where("ProductId",$PrdId)->first();

        if ($s == null) {
            return response()->json(["Result" => "Product Does Not Exist"], 500);
        }

        if ($req->hasFile('Background')) {
            $s->Background = $req->file('Background')->store('', 'public');
        }

        if ($req->hasFile('Document')) {
            $s->Document = $req->file('Document')->store('', 'public');
        }

        if($req->filled("Section")){
            $s->Section = $req->Section;
        }

        if($req->filled("Title")){
            $s->Title = $req->Title;
        }

        if($req->filled("Link")){
            $s->Link = $req->Link;
        }


        $saver = $s->save();

        if ($saver) {
            return response()->json(["Result" => "Success"], 200);
        } else {
            return response()->json(["Result" => "Failed"], 500);
        }
    }


    public function DeletePortfolio($PrdId)
    {
        $s = SitePortfolio::where("ProductId", $PrdId)->first();

        if ($s == null) {
            return response()->json(["Result" => "Product Does Not Exist"], 500);
        }

        $deleted = $s->delete();

        if ($deleted) {
            return response()->json(["Result" => "Success"], 200);
        } else {
            return response()->json(["Result" => "Failed"], 500);
        }
    }






    function IdGenerator(): string {
        $randomID = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
        return $randomID;
        }





}
