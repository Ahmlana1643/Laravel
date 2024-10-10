<?php

namespace App\Http\services;

use App\Models\Category;

class CategoryService{
    //upload
    public function select($uuid = null){
        if($uuid){
            return category::where('uuid', $uuid)->select('id', 'uuid', 'title', 'slug')->firstOrFail();
        }

        return Category::latest()->get(['id', 'uuid', 'title', 'slug']);
    }
}
