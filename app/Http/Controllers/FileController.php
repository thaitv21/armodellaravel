<?php

namespace App\Http\Controllers;

use Aws\S3\S3Client;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class FileController extends \App\Http\Controllers\Controller
{

    protected $storage;

    public function __construct() {
        $this->storage = Storage::disk('s3');
    }

    public function show()
    {
        $files = [];
        foreach ($this->storage->allFiles("/models") as $file) {
            array_push($files, ['name' => basename($file)]);
        }
        asort($files);
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
            $request->file('model')->storeAs('models', $name, 's3');
        }
        return redirect('/index');
    }

    public function download($filename) {
        $path = 'models/'.$filename;
        if (!$this->storage->exists($path)) {
            return view('error', ["err" => "Oops! $filename isn't exists..."]);
        }
        $url = Storage::disk('s3')->temporaryUrl($path, Carbon::now()->addMinutes(30));
        return redirect($url);

    }
}
