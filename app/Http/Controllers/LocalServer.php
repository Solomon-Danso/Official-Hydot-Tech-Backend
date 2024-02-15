<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\CompanyToken;
use App\Models\RegisterCompany;
use App\Mail\Clients;
use App\Mail\UpdateClients;
use App\Mail\DeleteClients;
use App\Mail\Subscription;
use App\Mail\Setup;
use App\Jobs\BulkUploadCompanies;
use App\Jobs\BulkUpdateCompanies;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Models\PaymentConfiguration;
use App\Models\PaymentHistory;
use App\Models\SitePortfolio;
use App\Models\AuditTrail;
use App\Models\CompanySetUp;


class LocalServer extends Controller
{

    function LocalRegisterCompany(Request $req){
        $s = new RegisterCompany();
        $response = Http::get("https://api.hydottech.com/api/GetOneCompany/".$req->CompanyId);

        if ($response->successful()) {
            $h = $response->json();

            if (isset($h['CompanyLogo'])) {
                $logoUrl = "https://api.hydottech.com/storage/public/" . $h['CompanyLogo'];

                // Define the path to store the logo in the public directory
                $storagePath = 'images/company_logo'; // Path relative to the 'public' folder

                // Create the directory if it doesn't exist
                if (!file_exists(public_path($storagePath))) {
                    mkdir(public_path($storagePath), 0755, true);
                }

                $filename = 'logo.jpg'; // Define the filename or generate one dynamically
                $downloadedFilePath = public_path($storagePath . '/' . $filename);

                // Use Guzzle HTTP client to download the image and store it in the public folder
                $httpClient = new \GuzzleHttp\Client();
                $response = $httpClient->get($logoUrl);

                if ($response->getStatusCode() === 200) {
                    file_put_contents($downloadedFilePath, $response->getBody());

                    // Update the CompanyLogo field in the Setup model with the path relative to the 'public' folder
                    $s->CompanyLogo = $storagePath . '/' . $filename;
                } else {
                    // Handle unsuccessful image download
                    return response()->json(['message' => 'Failed to download the image'], 400);
                }

            }

            $s->CompanyId = $h['CompanyId'];
            $s->CompanyName = $h['CompanyName'];

            $s->Location = $h['Location'];
            $s->ContactPerson = $h['ContactPerson'];

            $s->CompanyPhone = $h['CompanyPhone'];
            $s->CompanyEmail = $h['CompanyEmail'];

            $s->ContactPersonPhone = $h['ContactPersonPhone'];
            $s->ContactPersonEmail = $h['ContactPersonEmail'];

            $s->CompanyStatus = $h['CompanyStatus'];
            
            $s->Token = $h['Token'];

            $c = RegisterCompany::where("CompanyId",$req->CompanyId)->first();


            if($c){
            
                if (isset($h['CompanyLogo'])) {
                    $logoUrl = "https://api.hydottech.com/storage/public/" . $h['CompanyLogo'];
    
                    // Define the path to store the logo in the public directory
                    $storagePath = 'images/company_logo'; // Path relative to the 'public' folder
    
                    // Create the directory if it doesn't exist
                    if (!file_exists(public_path($storagePath))) {
                        mkdir(public_path($storagePath), 0755, true);
                    }
    
                    $filename = 'logo.jpg'; // Define the filename or generate one dynamically
                    $downloadedFilePath = public_path($storagePath . '/' . $filename);
    
                    // Use Guzzle HTTP client to download the image and store it in the public folder
                    $httpClient = new \GuzzleHttp\Client();
                    $response = $httpClient->get($logoUrl);
    
                    if ($response->getStatusCode() === 200) {
                        file_put_contents($downloadedFilePath, $response->getBody());
    
                        // Update the CompanyLogo field in the Setup model with the path relative to the 'public' folder
                        $c->CompanyLogo = $storagePath . '/' . $filename;
                    } else {
                        // Handle unsuccessful image download
                        return response()->json(['message' => 'Failed to download the image'], 400);
                    }
    
                }
                
            $c->CompanyId = $h['CompanyId'];
            $c->CompanyName = $h['CompanyName'];

            $c->Location = $h['Location'];
            $c->ContactPerson = $h['ContactPerson'];

            $c->CompanyPhone = $h['CompanyPhone'];
            $c->CompanyEmail = $h['CompanyEmail'];

            $c->ContactPersonPhone = $h['ContactPersonPhone'];
            $c->ContactPersonEmail = $h['ContactPersonEmail'];

            $c->CompanyStatus = $h['CompanyStatus'];
          
            $c->Token = $h['Token'];

            $saver = $c->save();

            if($saver){
                return response()->json(["message" => $c->CompanyName." Setup Completed"],200);
            }
            else{
                return response()->json(['message' => 'Please ensure your internet connection is active. The provided Token is incorrect or has expired.'], 400);

            }
            

            }


            $saver = $s->save();

            if($saver){
                return response()->json(["message" => $s->CompanyName." Setup Completed"],200);
            }
            else{
                return response()->json(['message' => 'Please ensure your internet connection is active. The provided Token is incorrect or has expired.'], 400);

            }









        }




    }


    function LocalCompanySetUp(Request $req) {

        $comp = RegisterCompany::where("CompanyId", $req->CompanyId)->first();
        if(!$comp){
            return response()->json(["message"=>"Company not found"],400);
        }


        $response = Http::get("https://api.hydottech.com/api/GetPriceConfigurationForOneProduct/".$req->ProductId);

        if ($response->successful()) {

            $product = $response->json();



        $s = new CompanySetUp();
    
        $s->CompanyId = $comp->CompanyId;
        $s->CompanyLogo = $comp->CompanyLogo;
        $s->CompanyName = $comp->CompanyName;
        $s->Location = $comp->Location;
        $s->ContactPerson = $comp->ContactPerson;
        $s->CompanyPhone = $comp->CompanyPhone;
        $s->CompanyEmail = $comp->CompanyEmail;
        $s->ContactPersonPhone = $comp->ContactPersonPhone;
        $s->ContactPersonEmail = $comp->ContactPersonEmail;
        $s->CompanyStatus = $comp->CompanyStatus;
        $s->ProductId = $product["ProductId"];
        $s->ProductName = $product["ProductName"];
        $s->Token = $this->TokenGenerator();
       
        $s->ExpireDate = Carbon::now()->addMinutes(15);
    
        $checker = CompanySetUp::where("ProductId",  $s->ProductId)->where("CompanyId", $s->CompanyId)->first();
        if($checker){
            return response()->json(["message"=>"Company already assigned to this product"],400);
        }
    
        $saver = $s->save();
            if ($saver) {
                $this->Auditor("SetUp A Company");
                return response()->json(["message" => "Success"], 200);
    
            } else {
                return response()->json(["Request" => "Failed"], 400);
            }
    

        }
       
    
    
    
    
    
       }
    

    function GetCompanyListDesc() {
        return RegisterCompany::orderBy('created_at', 'desc')->get();
    }
    


    
    function SetupTokenViewer(Request $req){
        $checker = CompanySetUp::where("ProductId",  $req->ProductId)->where("CompanyId", $req->CompanyId)->latest()->first();
        if(!$checker){
            return response()->json(["message"=>"Company Not Found"],400);
        }

        return $checker->Token;

       }

    
       function SubscribeTokenViewer(Request $req){
        $checker = CompanyToken::where("ProductId",  $req->ProductId)->where("CompanyId", $req->CompanyId)->latest()->first();
        if(!$checker){
            return response()->json(["message"=>"Company Not Found"],400);
        }

        return $checker->Token;

       }


  
  
  
       function TestLocalRegisterCompany(Request $req){
           
        $response = Http::get("https://api.hydottech.com/api/GetOneCompany/".$req->CompanyId);

        if ($response->successful()) {
            return $response->json();
        }




    }



    function GetPriceConfigurationForOneProduct($ProductId){
        $S = PaymentConfiguration::where("ProductId",$ProductId)->first();
        return $S;
    }

    function CreateLocalPaymentHub(Request $req){
        $P = new PaymentHistory();

        $C = RegisterCompany::where("CompanyId",$req->CompanyId)->first();

        if(!$C){
            return response()->json(["message"=>"Company not found"],400);
        }

        $response = Http::get("https://api.hydottech.com/api/GetPriceConfigurationForOneProduct/".$req->ProductId);

        if ($response->successful()) {
           
            $S = $response->json();

            $P->CompanyId = $C->CompanyId;
            $P->CompanyName = $C->CompanyName;
            $P->CompanyEmail = $C->CompanyEmail;
            $P->CompanyPhone = $C->CompanyPhone;
            $P->PaymentId = $this->IdGenerator();
   
        if($req->filled("PaymentMethod")){
            $P->PaymentMethod = $req->PaymentMethod;
        }
        if($req->filled("Amount")){
            $P->Amount = $req->Amount;
        }

            $P->ProductId = $S['ProductId'];
        
       
            $P->ProductName = $S['ProductName'];

            $P->SubscriptionPeriodInDays = ceil($P->Amount / $S['MarginalPrice']);


        $saver = $P->save();
        if($saver){
            $S->ActiveUsers = $S->ActiveUsers+1;
            $S -> Save();
            $this->Auditor("Created Company Token");
            $this->CreateCompanyToken($P->CompanyId, $P->SubscriptionPeriodInDays, $P->ProductId);
        }
        else{
            return response()->json(["message"=>"Failed To Add Payment"],400);
        }
       


        }
        else{
            return response()->json(["message"=>"No Payment Configuration For This Product"],400);  
        }



    }


    function CreateCompanyToken($CompanyId, $SubScri, $ProductId){
        $c = RegisterCompany::where("CompanyId", $CompanyId)->first();
    
        if(!$c){
            return response()->json(["message" => "Company Not Found"], 400);
        }
    
        $t =  new CompanyToken();
    
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
        $t->Subcriptions = $SubScri;
        $t->ProductId = $ProductId;
        $currentDate = Carbon::now();
    
        $t->StartDate = $currentDate;
        $t->SystemDate = $currentDate;
    
        // Check if the combination of CompanyId and ProductId already exists
        $existingToken = CompanyToken::where('CompanyId', $CompanyId)->where('ProductId', $ProductId)->first();
    
        if($existingToken){
            // Add the new subscription days to the remaining days of the existing subscription
            $existingExpireDate = Carbon::parse($existingToken->ExpireDate);
            $existingRemainingDays = $existingExpireDate->diffInDays($currentDate);
    
            $extendedExpireDate = $currentDate->copy()->addDays($SubScri + $existingRemainingDays);
            $existingToken->ExpireDate = $extendedExpireDate;
            $saver=$existingToken->save();

            if($saver){
                

                //Send a post request to the user 
                return response()->json(["message"=>"Success"],200);
            } else {
                return response()->json(["Request" => "Failed"], 400);
            }


    
            // You may return a response here or perform additional actions as needed for the update of an existing subscription
        } else {
            $expireDate = $currentDate->copy()->addDays($SubScri);
    
            $t->ExpireDate = $expireDate;
            $t->TokenStatus = "Active";
    
            $saver = $t->save();
    
            if($saver){
                // Send email if the request is successful
                return response()->json(["message"=>"Success"],200);
            } else {
                return response()->json(["Request" => "Failed"], 400);
            }
        }
    }



    function IdGenerator(): string {
        $randomID = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
        return $randomID;
        }










}
