<?php

declare(strict_types=1);

namespace Orchid\Backup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class BackupDownloadFileController extends Controller
{
    function downloadFile($file_name){   	
        $storage = config('filesystems.default');
        $path = 'Laravel/';
                
        $file = Storage::disk($storage)->get($path . $file_name);

        return (new Response($file, 200))
              ->header('Content-Type', 'application/octet-stream');
    }    
}
