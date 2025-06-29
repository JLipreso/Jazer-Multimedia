<?php

namespace Jazer\Multimedia\Http\Controllers\Upload;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Photo extends Controller
{
    public static function upload(Request $request) {

        if (!$request->hasFile('image') || !$request->file('image')->isValid()) {
            return [
                'success' => false,
                'message' => 'Invalid image file'
            ];
        }

        $image = $request->file('image');

        $ext           = $image->guessExtension() ?: 'jpg'; 
        $sizeInBytes   = $image->getSize();
        $localPath     = $image->getRealPath();
        $reference_id  = \Jazer\Multimedia\Http\Controllers\Utility\ReferenceID::create('IMG');
        $dateFolder    = date('Y-m-d');
        $filename      = $reference_id . '.' . $ext;
        $ftpSubDir     = config('jtmultimediaconfig.ftp_directory') . "/" . $dateFolder;
        $ftpRoot       = "public_html/";
        $ftpcon        = \Jazer\Multimedia\Http\Controllers\Utility\FTPConnection::connect();

        if (!$ftpcon) {
            ftp_close($ftpcon);
            return [
                'success' => false,
                'message' => 'FTP login failed'
            ];
        }

        ftp_pasv($ftpcon, true);

        $verify_folder = \Jazer\Multimedia\Http\Controllers\Utility\CreateFolderIfNotExist::create($ftpcon, $ftpRoot, $dateFolder);
        if(!$verify_folder) {
            return [
                'success' => true,
                'message' => 'Fail to created FTP folder'
            ];
        }

        $remotePath = $ftpSubDir . '/' . $filename;
        $upload     = ftp_put($ftpcon, $ftpRoot . $remotePath, $localPath, FTP_BINARY);

        ftp_close($ftpcon);

        if ($upload) {
            $save_db = DB::connection("conn_multimedia")->table("multimedia")->insert([
                "project_refid"     => config('jtmultimediaconfig.project_refid'),
                "reference_id"      => $reference_id,
                "file_path"         => $remotePath,
                "file_extension"    => $ext,
                "folder"            => $dateFolder,
                "file_name"         => $filename,
                "file_bytes_size"   => $sizeInBytes,
                "caption"           => $request['caption'] ?? null,
                "created_by"        => $request['created_by'] ?? null,
                "created_at"        => date('Y-m-d'),
                "public"            => $request['public'] ?? '0',
                "shareable"         => $request['shareable'] ?? '0'
            ]);

            return [
                'success'      => true,
                'reference_id' => $reference_id,
                'filename'     => $filename,
                'remotePath'   => $remotePath,
                'ftp_host'     => config('jtmultimediaconfig.ftp_host')
            ];
        }
        else {
            return [
                'success'      => false,
                'reference_id' => $reference_id,
                'message'      => 'FTP upload failed'
            ];
        }
    }
}