<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TempImageController extends Controller
{

    public function store(Request $request)
    {
        $image = collect($request->data)->first()['filepond'];
        $validator = Validator::make(["file" => $image], [
            "file" => [
                'required',
                'image',
                File::types(['jpg', 'png', 'jpeg'])->max(2048)
            ]
        ]);

        if ($validator->fails()) {
            return response(["status" => 400, "messages" => $validator->errors()->all()], 422);
        }

        $fileName = $image->hashName();
        $image->move(storage_path('app/temp'), $fileName);
        return  'temp/'.$fileName;
    }

    public function destroy(Request $request)
    {
        $file = $request->getContent();
        if (Storage::exists($file)) {
            Storage::delete($file);
            return 'Deleted';
        }
        return response('Not Found', 404);
    }

}
