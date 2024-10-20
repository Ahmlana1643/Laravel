<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\VideoRequest;
use App\Http\services\VideoService;
use App\Http\Controllers\Controller;
use App\Http\services\MiddlewareService;


class VideoController extends Controller
{
    public function __construct(

        private VideoService $videoService,
        public MiddlewareService $MiddlewareService
        ){
            $this->MiddlewareService->aksesRole();
        }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.video.index', [
            'videos' => $this->videoService->select(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.video.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VideoRequest $request)
    {
        $data = $request->validated();

        try {
            $this->videoService->create($data);

            return redirect()->route('panel.video.index')->with('success', 'Video has been created');
        } catch (\Exception $error) {
            return redirect()->back()->with('error', $error->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        $video = $this->videoService->selectFirstBy($uuid);
        return view('backend.video.show', [
            'video' => $video
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $uuid)
    {
        return view('backend.video.edit', [
            'video' => $this->videoService->selectFirstBy($uuid)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VideoRequest $request, string $uuid)
    {
        $video = $request->validated();
        try {
            $this->videoService->update($video, $uuid);


            return redirect()->route('panel.video.index')->with('success', 'Video has been updated');
        } catch (\Exception $error) {
            return redirect()->back()->with('error', $error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        try {
            $video = $this->videoService->selectFirstBy($uuid);
            $video->delete();

            return response()->json([
               'message' => 'Video has been deleted'
            ]);
        } catch (\Exception $error) {
            return response()->json([
               'message' => 'Video has not been deleted error: ' . $error->getMessage()
            ]);
        }
    }
}
