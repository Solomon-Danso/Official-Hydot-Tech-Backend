<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\RegisterCompany;
use App\Mail\Clients;

class BulkUploadCompanies implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;

    /**
     * Create a new job instance.
     *
     * @param mixed $file
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Load the uploaded Excel file
        $rows = Excel::toArray([], $this->filePath, null, \Maatwebsite\Excel\Excel::XLSX);


        if (count($rows) > 0) {
            foreach ($rows[0] as $row) {
                $company = new RegisterCompany();

                
                $company->CompanyId = $this->IdGenerator();
                $company->CompanyName = $row[0];
                $company->Location = $row[1];
                $company->ContactPerson = $row[2];
                $company->CompanyPhone = $row[3];
                $company->CompanyEmail = $row[4];
                $company->ContactPersonPhone = $row[5];
                $company->ContactPersonEmail = $row[6];

              
                $company->CompanyStatus = "Active";

                try {
                    $saved = $company->save();

                    if ($saved) {
                       
                        Mail::to($company->CompanyEmail)->send(new Clients($company));
                    }
                } catch (\Exception $e) {
                   
                    continue; 
                }
            }
        }
    }



     function IdGenerator(): string {
        $randomID = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
        return $randomID;
        }



}
