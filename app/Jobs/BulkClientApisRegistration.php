<?php

// App/Jobs/ProcessBulkClientApiRegistration.php

namespace App\Jobs;

use App\Models\ClientApi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;


class BulkClientApisRegistration implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
   
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
       
    }

    public function handle()
    {
        $rows = Excel::toArray([], $this->filePath, null, \Maatwebsite\Excel\Excel::XLSX);
    
        if (count($rows) > 0) {
            $headers = $rows[0][0]; // Assuming the headers are in the first row
    
            for ($i = 1; $i < count($rows[0]); $i++) {
                $row = $rows[0][$i];
    
                $s = new ClientApi();
    
                
    
                foreach ($headers as $index => $header) {
                    $s->{$header} = $row[$index];
                }
    
              
                $saver = $s->save();
    
                if (!$saver) {
                    continue;
                }
            }
        }
    }
    
}
