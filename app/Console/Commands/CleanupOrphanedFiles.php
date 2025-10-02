<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TcRequest;

class CleanupOrphanedFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:orphaned-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up orphaned file references in TC requests';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for orphaned file references...');
        
        $tcRequests = TcRequest::whereNotNull('attached_file')->get();
        $cleanedCount = 0;
        
        foreach ($tcRequests as $req) {
            $filePath = public_path($req->attached_file);
            
            if (!file_exists($filePath)) {
                $this->warn("Cleaning up missing file for request ID: {$req->id} - {$req->attached_file}");
                $req->update(['attached_file' => null]);
                $cleanedCount++;
            } else {
                $this->info("File exists for request ID: {$req->id} - {$req->attached_file}");
            }
        }
        
        $this->info("Cleanup completed. Cleaned up {$cleanedCount} orphaned file references.");
        
        return 0;
    }
}