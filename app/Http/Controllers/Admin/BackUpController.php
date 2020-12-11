<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Carbon\Carbon;
use Log;
use Spatie\Backup\Helpers\Format;
use Storage;
use File;
use Config;

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
        // The human readable folder name to get the contents of...
        // For simplicity, this folder is assumed to exist in the root directory.
        $folder = env('GOOGLE_DRIVE_FOLDER_ID');

        // Get the files inside the folder...
        $files = collect(Storage::cloud()->listContents('/', false))
        ->where('type', '=', 'file')->sortByDesc('timestamp');

        $files->mapWithKeys(function($file) {
            $filename = $file['filename'].'.'.$file['extension'];
            $path = $file['path'];

            return [$filename => $path];
        });

        if($files == '[]'):
            if(file_exists(Config::get('filesystems.disks.backups.root').'/'.env('GOOGLE_DRIVE_FOLDER_ID'))):
                rmdir(Config::get('filesystems.disks.backups.root').'/'.env('GOOGLE_DRIVE_FOLDER_ID') );//BORRA CARPETA LOCAL
            endif;
        endif;

        return view('admin.backups.backups')->with(compact('files')); //RETORNA LISTADO DE ARCHIVOS DRIVE
    }

    public function create(){
        Artisan::call('backup:run', ['--only-db' => 'true']); //CREA ARCHIVO

		return back()->with('message','Backup realizado con éxito. Se cargó correctamente a Google Drive.')->with('typealert','success')->withInput();    
    }

    public function dowload($name){
        $folder = env('GOOGLE_DRIVE_FOLDER_ID');

        $dir = '/';
        $recursive = false; // Get subdirectories also?
        $contents = collect(Storage::cloud()->listContents($dir, $recursive));

        $file = $contents
        ->where('type', '=', 'file')
        ->where('filename', '=', pathinfo($name, PATHINFO_FILENAME))
        ->where('extension', '=', pathinfo($name, PATHINFO_EXTENSION))
        ->first(); // there can be duplicate file names!

        //return $file; // array with file info

        // Store the file locally...
        $readStream = Storage::cloud()->getDriver()->readStream($file['path']);
        $targetFile = storage_path("downloaded-{$name}");
        file_put_contents($targetFile, stream_get_contents($readStream), FILE_APPEND);

        // Stream the file to the browser...
        $readStream = Storage::cloud()->getDriver()->readStream($file['path']);

        return response()->stream(function () use ($readStream) {
            fpassthru($readStream);
        }, 200, [
            'Content-Type' => $file['mimetype'],
            'Content-disposition' => 'attachment; filename="'.$name.'"', // DESCARGA
        ]);

    }

    public function delete($name){
        $folder = env('GOOGLE_DRIVE_FOLDER_ID');

        $dir = '/';
        $recursive = false; // Get subdirectories also?
        $contents = collect(Storage::cloud()->listContents($dir, $recursive));

        $file = $contents
        ->where('type', '=', 'file')
        ->where('filename', '=', pathinfo($name, PATHINFO_FILENAME))
        ->where('extension', '=', pathinfo($name, PATHINFO_EXTENSION))
        ->first(); // there can be duplicate file names!

        Storage::cloud()->delete($file['path']);//BORRA DE DRIVE
        unlink(Config::get('filesystems.disks.backups.root').'/'.env('GOOGLE_DRIVE_FOLDER_ID').'/'.$name );//BORRA DE CARPETA LOCAL

        return back()->with('message','Backup eliminado.')->with('typealert','success')->withInput();     
        }
    
}
