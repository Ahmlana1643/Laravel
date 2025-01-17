<?php

namespace App\Http\services;

use Illuminate\Support\Str;
use App\Models\Menu;

class MenuService{

    public function select($paginate = null)
    {

        if ($paginate) {
            return Menu::with('category:id,title')->latest()->select('id', 'uuid', 'name', 'category_id', 'price', 'status', 'image')->paginate($paginate);
        }

        return Menu::latest()->get();

    }
    public function selectFirstBy($coloumn, $value)
    {
        return Menu::with('category:id,title')->where($coloumn, $value)->firstOrFail();
    }
    public function create($data)
    {

        $data['slug'] = Str::slug($data['name']);

        return Menu::create($data);

    }
    public function update($data, $uuid)
    {

        $data['slug'] = Str::slug($data['name']);

        return Menu::where('uuid', $uuid)->update($data);

    }
}
