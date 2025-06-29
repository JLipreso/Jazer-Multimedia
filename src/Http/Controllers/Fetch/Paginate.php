<?php

namespace Jazer\Multimedia\Http\Controllers\Fetch;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Paginate extends Controller
{
    public static function paginate(Request $request) {

        if((isset($request['keyword'])) && ($request['keyword'] !== null )) {
            $source = DB::connection("conn_multimedia")
            ->table("multimedia")
            ->where([
                ["project_refid", "=", config('jtmultimediaconfig.project_refid')],
                ["file_name", "like", "%" . $request['keyword'] . "%" ]   
            ])
            ->orderBy("file_name", "asc")
            ->paginate(config('jtmultimediaconfig.fetch_paginate_max'))
            ->toArray();
        }
        else {
            $source = DB::connection("conn_multimedia")
            ->table("multimedia")
            ->where([
                "project_refid"     => config('jtmultimediaconfig.project_refid')
            ])
            ->orderBy("dataid", "desc")
            ->paginate(config('jtmultimediaconfig.fetch_paginate_max'))
            ->toArray();
        }

        $data       = $source['data'];
        $list       = [];

        foreach($data as  $index => $object) {;
            $list[]     = [
                "reference_id"      => $object->reference_id,
                "file_path"         => $object->file_path,
                "file_extension"    => $object->file_extension,
                "folder"            => $object->folder,
                "file_name"         => $object->file_name,
                "file_bytes_size"   => $object->file_bytes_size,
                "file_fullpath"     => config('jtmultimediaconfig.ftp_host') . $object->file_path,
                "caption"           => $object->caption,
                "created_by"        => $object->created_by,
                "created_at"        => $object->created_at,
                "public"            => \Jazer\Multimedia\Http\Controllers\Utility\NumberToBoolean::convert(intval($object->public)),
                "shareable"         => \Jazer\Multimedia\Http\Controllers\Utility\NumberToBoolean::convert(intval($object->shareable))
            ];
        }

        return \Jazer\Multimedia\Http\Controllers\Utility\Paginator::parse($source, $list);

    }
}