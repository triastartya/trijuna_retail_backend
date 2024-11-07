<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Viershaka\Vier\VierController;
use Illuminate\Support\Facades\Storage;

class backupController extends VierController
{
    public $repository;
    
    public function __construct()
    {
        // $this->repository = new SchemeRepository();
        // parent::__construct($this->repository);
    }

    public function runBackup()
    {
        try {
            // Run the backup command programmatically
            // Artisan::call('backup:run');
            Storage::disk('google_drive')->put('nama_file.txt', 'Isi dari file');

            // Optionally, return a response
            return response()->json(['message' => 'Backup is being processed.'], 200);
        } catch (\Exception $e) {
            // Handle exceptions or errors
            return response()->json(['message' => 'Backup failed. Error: ' . $e->getMessage()], 500);
        }
    }
}
