<?php

namespace Jazer\Multimedia\Http\Controllers\Update;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Rename extends Controller
{
    public static function rename(Request $request) {
        $source = DB::connection("conn_multimedia")->table("multimedia")
            ->where([
                "project_refid"     => config('jtmultimediaconfig.project_refid'),
                "reference_id"      => $request['reference_id']
            ])
            ->update([
                "file_name"         => $request['file_name']
            ]);
        if($source) {
            return [
                "success"   => true
            ];
        }
        else {
            return [
                "success"   => false
            ];
        }
    }
}