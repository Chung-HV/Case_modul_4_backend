<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UploadFileController extends Controller
{
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(),[
              'file' => 'required|mimes:doc,docx,pdf,txt,csv,png,jpg,jpeg,gif|max:2048',
        ]);

        if($validator->fails()) {

            return response()->json(['error'=>$validator->errors()], 401);
         }


        if ($file = $request->file('file')) {
            $path = $file->store('public/files');
            $name = $file->getClientOriginalName();

            //store your file into directory and db
            $save = new Image();
            $save->name = $file;
            $save->store_path= $path;
            $save->save();

            return response()->json([
                "success" => true,
                "message" => "File successfully uploaded",
                "file" => $file
            ]);
        }
    }
}
