<?php

namespace App\Http\services;

use App\Models\Event;

class EventService{

    public function select($paginate = null)
    {

        if ($paginate) {
            return Event::latest()->paginate($paginate);
        }

        return Event::latest()->get();

    }
    public function selectFirstBy($coloumn, $value)
    {
        return Event::where($coloumn, $value)->firstOrFail();
    }
    public function create($data)
    {

        return Event::create($data);

    }
    public function update($data, $uuid)
    {

        return Event::where('uuid', $uuid)->update($data);

    }
}
