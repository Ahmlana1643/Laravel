<?php

namespace App\Http\services;

use Illuminate\Support\Str;
use App\Models\Gallery\Video;

class VideoService{

    public function select($paginate = null)
    {

            return Video::latest()->paginate($paginate);

    }
    public function selectFirstBy(string $uuid)
    {
        return Video::where('uuid', $uuid)->firstOrFail();
    }
    public function create($data)
    {

        $video = [
            'slug' => Str::slug($data['title']),
            'video_link' => $this->formatVideoLink($data['video_link'])
        ];
        return Video::create(array_merge($data, $video));

    }

    private function formatVideoLink($link)
    {
        if (preg_match('/^(?:https?:\/\/)?(?:www\.)?(?:youtube\.com|youtu\.be)\/(?:watch\?v=)?(.+)$/i', $link, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }
    }
    public function update($data, $uuid)
    {

        $data['slug'] = Str::slug($data['title']);

        $data['video_link'] = $this->formatVideoLink($data['video_link']);

        return Video::where('uuid', $uuid)->update($data);

    }
}
