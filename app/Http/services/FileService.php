<?php

namespace App\Http\services;

use Illuminate\Support\Facades\Storage;

class FileService{
    //upload
    public function upload($file, $path){
        $uploaded = $file;

        $fileName = $uploaded->hashName();

        return $uploaded->storeAs($path, $fileName, 'public');
    }

    //delete
    public function delete($file){
        $deleted = unlink(storage_path('app/public/'.$file));

        return $deleted;
    }
}
