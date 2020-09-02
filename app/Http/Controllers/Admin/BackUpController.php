<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Carbon\Carbon;
use Log;
use Spatie\Backup\Helpers\Format;
use Storage;

class BackUpController extends Controller
{
	public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('estadoUsuario');
    	$this->middleware('permisosUsuario');
    	$this->middleware('isadmin');

    }

     public function index()
    {
    	/*
        $disk = Storage::disk(config('backup.backup.destination.disks')[0]);
        $files = $disk->files(config('backup.backup.name'));
        $backups = [];
        // make an array of backup files, with their filesize and creation date
        foreach ($files as $k => $f) {
            // only take the zip files into account
            if (substr($f, -4) == '.zip' && $disk->exists($f)) {
                $backups[] = [
                    'file_path' => $f,
                    'file_name' => str_replace(config('backup.backup.name') . '/', '', $f),
                    'file_size' => Format::humanReadableSize($disk->size($f)),
                    'last_modified' => Carbon::createFromTimestamp($disk->lastModified($f)),
                ];
            }
        }
        // reverse the backups, so the newest one would be on top
        $backups = array_reverse($backups);
        */
        return view('admin.backups.backups');//->with(compact('backups'));
    }

    public function create()
    {
        Artisan::call('backup:run', ['--only-db' => 'true']);
        $output = Artisan::output();
        
        Log::info("Backpack\BackupManager -- new backup started from admin interface \r\n" . $output);

		return back()->with('message','Backup realizado con éxito.')->with('typealert','success')->withInput();
    		     
    }
    
}
