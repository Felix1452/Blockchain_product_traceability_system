<?php

namespace App\Http\Services\Accuracy;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AccuracyService
{
    public function ChangeDBFix(){
        try {
            $migrationFile = '2023_06_14_114601_drop_all_tables.php'; // Replace with your migration file name

            // Run the specific migration
            Artisan::call('migrate', [
                '--path' => 'database/migrations/' . $migrationFile,
                '--force' => true, // Optional: Force the migration to run in production
            ]);

            // Get the output of the migration command
            $output = Artisan::output();

            // Display the output
            echo "SQL file imported successfully!";

            echo $output;


            $directoryPath = storage_path('app/backup');

            $files = File::files($directoryPath);

            if (!empty($files)) {
                $latestFile = collect($files)->sortByDesc(function ($file) {
                    return $file->getMTime();
                })->first();

                $latestFilePath = $latestFile->getPathname();

                echo $latestFilePath;
            } else {
                echo "No files found in the directory.";
            }


            $filePath = $latestFilePath;

            // Get the SQL file content
            $sql = file_get_contents($filePath);

            // Run the SQL queries
            DB::connection()->getPdo()->exec($sql);
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the migration
            echo "Migration failed: " . $e->getMessage();
        }
    }

}
