<?php

namespace Jazer\Multimedia\Http\Controllers\Upload;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Photo extends Controller
{
    public static function upload(Request $request) {

        $ext            = $request['image']->extension();
        $path           = $request['image']->path();
        $file           = $request['image']->getRealPath();
        $size           = $request['image']->getSize();

        $reference_id   = Jazer\Multimedia\Http\Controllers\Utility\ReferenceID::create('IMG');
        $ftpcon 		= ftp_connect(config('multimediaconfig.ftp_ip')) or die('Error connecting to ftp server...');
        $ftplogin 		= ftp_login($ftpcon, config('multimediaconfig.ftp_username'), config('multimediaconfig.ftp_password'));
        $filepath 	    = config('multimediaconfig.ftp_directory') . '/' . date('Y') . '/'. date('m') . date('/') . $reference_id . '.' .$ext;

        if (ftp_put($ftpcon, "public_html/" . $filepath, $_FILES['image']['tmp_name'], FTP_BINARY)) {

            return [
                "success"       => true,
                "reference_id"  => $reference_id,
                "message"       => "Upload successfully",
                "path"          => config("multimediaconfig.ftp_host") . $filepath
            ];
        }
        else {
            return [
                "success"       => false,
                "reference_id"  => $reference_id,
                "message"       => "Fail to upload"
            ];
        }
    }
}