<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\CompanyToken;
use App\Models\RegisterCompany;
use App\Mail\Clients;
use App\Mail\UpdateClients;
use App\Mail\DeleteClients;
use App\Jobs\BulkUploadCompanies;
use Maatwebsite\Excel\Facades\Excel;


class ClientController extends Controller
{
    function RegisterCompany(Request $req){
        $r = new RegisterCompany();

        $r->CompanyId = $this->IdGenerator();

        if($req->hasFile("CompanyLogo")){
            $r->CompanyLogo = $req->file("CompanyLogo")->store('','public');
        }

        if($req->filled("CompanyName")){
            $r->CompanyName = $req->CompanyName;
        }

        if($req->filled("Location")){
            $r->Location = $req->Location;
        }

        if($req->filled("ContactPerson")){
            $r->ContactPerson = $req->ContactPerson;
        }


        if($req->filled("CompanyPhone")){
            $r->CompanyPhone = $req->CompanyPhone;
        }


        if($req->filled("CompanyEmail")){
            $r->CompanyEmail = $req->CompanyEmail;
        }


        if($req->filled("ContactPersonPhone")){
            $r->ContactPersonPhone = $req->ContactPersonPhone;
        }

        if($req->filled("ContactPersonEmail")){
            $r->ContactPersonEmail = $req->ContactPersonEmail;
        }


        $r->CompanyStatus = "Active";


        $saver = $r->save();
        if ($saver) {
            // Send email if the request is successful
            try {
                Mail::to($r->CompanyEmail)->send(new Clients($r));
                return response()->json(["message" => "Success"], 200);
            } catch (\Exception $e) {
              
                return response()->json(["message" => "Email Failed"], 400);
            }

        } else {
            return response()->json(["Request" => "Failed"], 400);
        }





    }

    function UpdateCompany(Request $req, $CompanyId){
        $r = RegisterCompany::where("CompanyId",$CompanyId)->first();
        if($r==null){
            return response()->json(["message" => "Company not found"],400);
        }
       

        if($req->hasFile("CompanyLogo")){
            $r->CompanyLogo = $req->file("CompanyLogo")->store('','public');
        }

        if($req->filled("CompanyName")){
            $r->CompanyName = $req->CompanyName;
        }

        if($req->filled("Location")){
            $r->Location = $req->Location;
        }

        if($req->filled("ContactPerson")){
            $r->ContactPerson = $req->ContactPerson;
        }


        if($req->filled("CompanyPhone")){
            $r->CompanyPhone = $req->CompanyPhone;
        }


        if($req->filled("CompanyEmail")){
            $r->CompanyEmail = $req->CompanyEmail;
        }


        if($req->filled("ContactPersonPhone")){
            $r->ContactPersonPhone = $req->ContactPersonPhone;
        }

        if($req->filled("ContactPersonEmail")){
            $r->ContactPersonEmail = $req->ContactPersonEmail;
        }


        if($req->filled("CompanyStatus")){
            $r->CompanyStatus = $req->CompanyStatus;
        }


        $saver = $r->save();

        if ($saver) {
            // Send email if the request is successful
            try {
                Mail::to($r->CompanyEmail)->send(new UpdateClients($r));
                return response()->json(["message" => "Success"], 200);
            } catch (\Exception $e) {
              
                return response()->json(["message" => "Email Failed"], 400);
            }

        } else {
            return response()->json(["message" => "Failed"], 400);
        }





    }

    function GetCompany(){
        return RegisterCompany::all();
    }

    function DeleteCompany($CompanyId){
        $r = RegisterCompany::where("CompanyId",$CompanyId)->first();
        if($r==null){
            return response()->json(["message"=>"Company not found"],400);
        }

        $saver = $r->delete();

        if ($saver) {
            // Send email if the request is successful
            try {
                Mail::to($r->CompanyEmail)->send(new DeleteClients($r));
                return response()->json(["message" => "Success"], 200);
            } catch (\Exception $e) {
              
                return response()->json(["message" => "Email Failed"], 400);
            }

        } else {
            return response()->json(["message" => "Failed"], 400);
        }


    }

    public function bulkUpload(Request $request)
    {
        if ($request->hasFile('excel_file')) {
            $file = $request->file('excel_file');
    
            // Pass the file path to the job
            $filePath = $file->getPathname();
            BulkUploadCompanies::dispatch($filePath);
    
            return response()->json(["message" => "Bulk Upload Successful"], 200);
        }
    
        return response()->json(["message" => "No file uploaded or error occurred"], 400);
    }














































































    function IdGenerator(): string {
        $randomID = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
        return $randomID;
        }
}
