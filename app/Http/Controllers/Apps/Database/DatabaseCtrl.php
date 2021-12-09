<?php

namespace App\Http\Controllers\Apps\Database;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Controller;
use Spatie\Backup\Helpers\Format;
use Response;
use Artisan;
use Log;
use Storage;
use File;
use DB;

class DatabaseCtrl extends Controller
{
    public function index(Request $request)
    {
        $disk = Storage::disk(config('laravel-backup.backup.destination.disks')[0]);
        $files = $disk->files('backup_db');
        // cetak_r($files);
        $backup = [];
        // make an array of backup files, with their filesize and creation date
        if (count($files) > 0) {
            foreach ($files as $key => $value) {
                $backup[] = [
                    'file_path' => $value,
                    'file_name' => str_replace('backup_db/', '', $value),
                    'file_size' => $disk->size($value),
                    'last_modified' => date("d M Y H:i:s", $disk->lastModified($value)),
                ];
            }
            $data = array_reverse($backup);
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $itemCollection = collect($data);
            $perPage = 25;
            $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
            $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
            $paginatedItems->setPath($request->url());
            return response($paginatedItems);
        } else {
            return "empty";
        }
    }

    public function backup()
    {
        try {
            Artisan::call('backup:run');
            $disk = Storage::disk(config('laravel-backup.backup.destination.disks')[0]);
            $files = $disk->files('http---localhost');
            // cetak_r($files);
            $backup = [];
            foreach ($files as $key => $value) {
                $backup[] = [
                    'file_path' => $value,
                    'file_name' => str_replace('http---localhost/', '', $value),
                    'file_size' => $disk->size($value),
                    'last_modified' => date("d M Y H:i:s", $disk->lastModified($value)),
                ];
            }
            $data = end($backup);
            if(!File::exists(storage_path('app/backup_db/'))) {
                File::makeDirectory(storage_path('app/backup_db/'));
            }

            $resData = File::move(storage_path('app/http---localhost/'.$data['file_name']), storage_path('app/backup_db/'.'DB_CMA-'.$data['file_name']));
            // cetak_r($resData);

            return "success";
        } catch (Exception $e) {
            return "error";
        }
    }
    /**
     * Downloads a backup zip file.
     *
     * TODO: make it work no matter the flysystem driver (S3 Bucket, etc).
     */
    public function download($filename)
    {
        try {
            $file = storage_path('app/backup_db/'.$filename);
            return response()->download($file);
        } catch (Exception $e) {
            return "error";
        }
    }
}
