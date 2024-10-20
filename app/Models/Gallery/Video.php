<?php

namespace App\Models\Gallery;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'title',
        'slug',
        'video_link',
    ];

    public static function booted(){

        static::creating(function($model){
            $model->uuid = Str::uuid();
        });
    }
}
