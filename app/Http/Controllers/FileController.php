<?php

namespace App\Http\Controllers;

use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends \App\Http\Controllers\Controller
{
    public function show()
    {
        $files = [];
        foreach (Storage::files("/models") as $file) {
            array_push($files, ['name' => basename($file)]);
        }
        return view('index', ['files' => $files]);
    }

    public function showUpload() {
        if (!Auth::check()) {
            return redirect()->route('home');
        }
        return view('upload');
    }

    public function upload(Request $request)
    {
        ini_set('memory_limit', '-1');
        print_r("Model=".($request->hasFile('model'))."...");
        if ($request->hasFile('model')) {
            $file = $request->model;
            $name = $file->getClientOriginalName();
            Storage::disk('local')->put("models/".$name, fopen($file, 'r+'));
        }
        return redirect('/index');
    }

    public function download($filename) {
        return response()->download(storage_path('app/models/'.$filename));
    }
}
