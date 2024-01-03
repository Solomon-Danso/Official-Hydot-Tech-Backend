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
use App\Models\PaymentConfiguration;
use App\Models\PaymentHistory;
use App\Models\SitePortfolio;
use App\Models\AuditTrail;



class ClientController extends Controller
{

    function GetAuditTrial() {
        return AuditTrail::orderBy('created_at', 'desc')->get();
    }
    

    function GetTodayAuditTrial() {
        return AuditTrail::whereDate('created_at', today())->count();
    }
    




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
            $this->Auditor("Registered A Company");
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
            $this->Auditor("Updated A Company");
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
    function GetOneCompany($CompanyId){
        $a = RegisterCompany::where("CompanyId",$CompanyId)->first();
        if(!$a){
            return response()->json(["message"=>"Company not found"],400);
        }
      
        return $a;
    }

    function DeleteCompany($CompanyId){
        $r = RegisterCompany::where("CompanyId",$CompanyId)->first();
        if($r==null){
            return response()->json(["message"=>"Company not found"],400);
        }

        $saver = $r->delete();

        if ($saver) {
            $this->Auditor("Deleted A Company");
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
            $this->Auditor("Bulk Upload Of Companies");
    
            return response()->json(["message" => "Bulk Upload Successful"], 200);
        }
    
        return response()->json(["message" => "No file uploaded or error occurred"], 400);
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
                // Send email if the request is successful
                try {
                    Mail::to($t->CompanyEmail)->send(new Subscription($existingToken));
                    return response()->json(["message" => "Token Sent Successfully"], 200);
                } catch (\Exception $e) {
                    return response()->json(["message" => "Email Failed To Send"], 400);
                }
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
    }
    

    function CompanyToken(Request $req){
        $c = CompanyToken::where("Token",$req->token)->first();
    
        if(!$c){
            return response()->json(["message" => "Invalid Token, Try Again"], 400);
        }
    
        // Get current date as Carbon instance
        $currentDate = Carbon::now();
    
        // Update the 'CurrentDate' field in the CompanyToken model
        $c->CurrentDate = $currentDate;
        $c->save();
    
        $this->Auditor("Get Company Token");
    
    
        // Compare the Carbon instances directly
        if($currentDate > $c->ExpireDate){
            return response()->json(["message" => "Token has expired"], 400);
        }
        
        return $c;
    }


    function PricesConfiguration(Request $req){
        $p = new PaymentConfiguration();

        $s = SitePortfolio::where("ProductId",$req->ProductId)->first();

        if($s==null){
            return response()->json(["Result" => "Product Does Not Exist"], 500);
        }

        
        $p->ProductName = $s->Title;
        

        if($req->filled("MarginalPrice")){
            $p->MarginalPrice = $req->MarginalPrice;
        }

        if($req->filled("ProductId")){
            $p->ProductId = $req->ProductId;
        }

       

        $saver = $p->save();

        if($saver){
            $this->Auditor("Configured Prices");
            return response()->json(["message"=>"Success"],200);
        }
        else{
            return response()->json(["message"=>"Failed"],400);
        }




    }

    function UpdatePricesConfiguration(Request $req,$ProductId){
        $p = PaymentConfiguration::where("ProductId",$ProductId)->first();

        if(!$p){
            return response()->json(["message"=>"Product not found"],400);
        }

        if($req->filled("ProductName")){
            $p->ProductName = $req->ProductName;
        }

        if($req->filled("MarginalPrice")){
            $p->MarginalPrice = $req->MarginalPrice;
        }

       

        
        $saver = $p->save();

        if($saver){
            $this->Auditor("Updated Prices");
            return response()->json(["message"=>"Success"],200);
        }
        else{
            return response()->json(["message"=>"Failed"],400);
        }




    }

    function DeletePricesConfiguration($ProductId){
        $p = PaymentConfiguration::where("ProductId",$ProductId)->first();

        if(!$p){
            return response()->json(["message"=>"Product not found"],400);
        }


        
        $saver = $p->delete();

        if($saver){
            $this->Auditor("Deleted Prices");
            return response()->json(["message"=>"Success"],200);
        }
        else{
            return response()->json(["message"=>"Failed"],400);
        }




    }

    function GetPricesConfiguration(){
       
        return PaymentConfiguration::all();
    }


    

    function CreatePaymentHub(Request $req, $CompanyId){
        $P = new PaymentHistory();

        $C = RegisterCompany::where("CompanyId",$CompanyId)->first();

        if(!$C){
            return response()->json(["message"=>"Company not found"],400);
        }

        $S = PaymentConfiguration::where("ProductId",$req->ProductId)->first();

        if(!$S){
            return response()->json(["message"=>"No Payment Configuration For This Product"],400);
        }
        
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

            $P->ProductId = $S->ProductId;
        
       
            $P->ProductName = $S->ProductName;

            $P->SubscriptionPeriodInDays = ceil($P->Amount / $S->MarginalPrice);


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

    function GetPayment($CompanyId){
       
        return PaymentHistory::all();
    }

    function GetOnePayment($CompanyId){
        $a = PaymentHistory::where("CompanyId",$CompanyId)->get();
        if(!$a){
            return response()->json(["message"=>"Company not found"],400);
        }
       
        return $a;
    }

    public function SearchCompany(Request $req)
    {
        $searchTerm = $req->searchTerm;
        $this->Auditor("Search For Company");
        return RegisterCompany::where(function ($query) use ($searchTerm) {
            $query->where('CompanyName', 'like', '%' . $searchTerm . '%');
               
        })->get();
    }
    
    function Auditor($Action) {
        $ipAddress = $_SERVER['REMOTE_ADDR']; // Get user's IP address
    
        $ipDetails = json_decode(file_get_contents("https://ipinfo.io/{$ipAddress}/json"));
    
        $country = $ipDetails->country ?? 'Unknown';
        $city = $ipDetails->city ?? 'Unknown';
    
        // Get user agent information
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
    
        // Parse the user agent string to determine device and OS
        $device = $this->detectDevice($userAgent);
        $os =  $this->detectOperatingSystem($userAgent);
    
        // Current date and time
        $currentDate = now();
    
        // URL path
        $urlPath = $_SERVER['REQUEST_URI'];
    
       
        $latitude = $ipDetails->loc ?? ''; // Latitude
        $longitude = $ipDetails->loc ?? ''; // Longitude
        $googleMapsLink = "https://maps.google.com/?q={$latitude},{$longitude}";
    
        // Create a new AuditTrail instance and save the log to the database
        $auditTrail = new AuditTrail();
        $auditTrail->ipAddress = $ipAddress;
        $auditTrail->country = $country;
        $auditTrail->city = $city;
        $auditTrail->device = $device;
        $auditTrail->os = $os;
        $auditTrail->urlPath = $urlPath;
        $auditTrail->action = $Action; 
        $auditTrail->googlemap = $googleMapsLink;
        
        $auditTrail->save();
    }
    
    // Function to detect device type from User-Agent string
    function detectDevice($userAgent) {
        $isMobile = false;
        $mobileKeywords = ['Android', 'webOS', 'iPhone', 'iPad', 'iPod', 'BlackBerry', 'Windows Phone'];
    
        foreach ($mobileKeywords as $keyword) {
            if (stripos($userAgent, $keyword) !== false) {
                $isMobile = true;
                break;
            }
        }
    
        return $isMobile ? 'Mobile' : 'Desktop';
    }
    
    // Function to detect operating system from User-Agent string
    function detectOperatingSystem($userAgent) {
        $os = 'Unknown';
    
        $osKeywords = ['Windows', 'Linux', 'Macintosh', 'iOS', 'Android'];
    
        foreach ($osKeywords as $keyword) {
            if (stripos($userAgent, $keyword) !== false) {
                $os = $keyword;
                break;
            }
        }
    
        return $os;
    }
    






























































    function TokenGenerator(): string {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+{}|:<>-=[];\',./';
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
