<?php

namespace Jazer\Multimedia\Http\Controllers\Delete;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Photo extends Controller
{
    public static function delete(Request $request) {
        $source = DB::connection("conn_multimedia")->table("multimedia")
            ->select("reference_id", "file_path", "file_name")
            ->where([
                "project_refid"     => config('jtmultimediaconfig.project_refid'),
                "reference_id"      => $request['reference_id']
            ])
            ->get();
        if(count($source) > 0) {
            $ftpcon        = \Jazer\Multimedia\Http\Controllers\Utility\FTPConnection::connect();
            if(\Jazer\Multimedia\Http\Controllers\Utility\FTPFileExist::isExist($ftpcon, $source[0]->file_path)) {
                if (ftp_delete($ftpcon, "public_html/" . $source[0]->file_path)) {
                    ftp_close($ftpcon);
                    DB::connection("conn_multimedia")->table("multimedia")
                    ->select("reference_id", "file_path", "file_name")
                    ->where([
                        "project_refid"     => config('jtmultimediaconfig.project_refid'),
                        "reference_id"      => $request['reference_id']
                    ])
                    ->delete();
                    return [
                        "success"   => true,
                        "message"   => "Image delete successfully",
                        "data"      => $source[0]
                    ];
                } else {
                    ftp_close($ftpcon);
                    return ['success' => false, 'message' => 'Failed to delete the file'];
                }
            }
            else {
                return [
                    "success"   => false,
                    "message"   => "Image not found"
                ];
            }
        }
        else {
            return [
                "success"   => false,
                "message"   => "Image not found"
            ];
        }

        return $source;
    }
}