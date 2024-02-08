<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\CompanyToken;
use App\Models\RegisterCompany;
use App\Mail\Clients;
use App\Mail\UpdateClients;
use App\Mail\DeleteClients;
use App\Mail\Subscription;
use App\Jobs\BulkUploadCompanies;
use App\Jobs\BulkUpdateCompanies;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;


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

    function CreateCompanyToken(Request $req, $CompanyId){
        $c = RegisterCompany::where("CompanyId", $CompanyId)->first();
    
        if($c == null){
            return response()->json(["message" => "Company Not Found"], 400);
        }
    
        $t =  CompanyToken::firstOrNew();
    
        $t->CompanyId = $c->CompanyId;
        $t->CompanyLogo = $c->CompanyLogo;
        $t->CompanyName = $c->CompanyName;
        $t->Location = $c->Location;
        $t->ContactPerson = $c->ContactPerson;
        $t->CompanyPhone = $c->CompanyPhone;
        $t->CompanyEmail = $c->CompanyEmail;
        $t->ContactPersonPhone = $c->ContactPersonPhone;
        $t->ContactPersonEmail = $c->ContactPersonEmail;
        $t->CompanyStatus = $c->CompanyStatus;
        $t->Token = $this->TokenGenerator();
        $t->Subcriptions = $req->Subcriptions;
    
        $currentDate = Carbon::now();
    
        $t->StartDate = $currentDate;
        $t->SystemDate = $currentDate;
    
        // Calculate the expiration date using Carbon
        $expireDate = $currentDate->copy()->addDays($req->Subcriptions);
    
        $t->ExpireDate = $expireDate;
        $t->TokenStatus = "Active";
    
        $saver = $t->save();
    
        if($saver){
            // Send email if the request is successful
            try {
                Mail::to($t->CompanyEmail)->send(new Subscription($t));
                return response()->json(["message" => "Token Sent Successfully"], 200);
            } catch (\Exception $e) {
                return response()->json(["message" => "Email Failed To Send"], 400);
            }
        } else {
            return response()->json(["Request" => "Failed"], 400);
        }
    }

    function GetToken($token){
        $c = CompanyToken::where("Token",$token)->first();
    
        if(!$c){
            return response()->json(["message" => "Invalid Token, Try Again"], 400);
        }
    
        // Get current date as Carbon instance
        $currentDate = Carbon::now();
    
        // Update the 'CurrentDate' field in the CompanyToken model
        $c->CurrentDate = $currentDate;
        $c->save();
    
    
    
        // Compare the Carbon instances directly
        if($currentDate > $c->ExpireDate){
            return response()->json(["message" => "Token has expired"], 400);
        }
        
        return $c;
    }



































































    function TokenGenerator(): string {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+{}|:<>?-=[];\',./';
        $length = 20;
        $randomString = '';
    
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
    
        return $randomString;
    }
    



    function IdGenerator(): string {
        $randomID = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
        return $randomID;
        }
}
