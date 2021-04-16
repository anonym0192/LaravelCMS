<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    //

    function __construct(){
        
    }

    function uploadImage(Request $request){

        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png,gif'
            ]);
        
        $ext = $request->file->extension();
        $filename = time().'.'.rand(0, 9999).$ext;

        $request->file->move(public_path('media/images'), $filename);

        return [
            'location' => asset('media/images/'.$filename)
        ];
    }
}
