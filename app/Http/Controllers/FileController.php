<?php

namespace App\Http\Controllers;

use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class FileController extends \App\Http\Controllers\Controller
{

    protected $storage;

    public function __construct() {
        #"gs://armodel-9459b.appspot.com"
        $path = __DIR__ . '/firebase.json';
        $serviceAccount = ServiceAccount::fromJsonFile($path); // đường dẫn của file json ta vừa tải phía trên
        $this->storage = (new Factory())->withServiceAccount($serviceAccount)
            ->createStorage();
    }

    public function show()
    {
        $files = [];
        foreach ($this->storage->getBucket()->objects() as $file) {
            $name = $file->info()['name'];
            array_push($files, ['name' => $name]);
        }
//        $disk = Storage::disk('local');
//        foreach ($disk->allFiles("/models") as $file) {
//            array_push($files, ['name' => basename($file)]);
//        }
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
            $this->storage->getBucket()->upload(base64_encode(file_get_contents($file->path())), ["name" => $name]);
        }
        return redirect('/index');
    }

    public function download($filename) {
        $file = $this->storage->getBucket()->object($filename);
        if (!$file->exists() || pathinfo($file->info()['name'])['extension'] != 'fbx') {
            return view('error', ["err" => "Oops! $filename is not exists"]);
        }
        $expires = new \DateTimeImmutable('+60 minute');
        return redirect($file->signedUrl($expires));
    }
}
