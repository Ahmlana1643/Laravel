<?php

namespace App\Http\Controllers\Backend;

use App\Http\services\FileService;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Http\services\EventService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class EventController extends Controller
{
    public function __construct(
        private FileService $fileService,
        private EventService $eventService,
    ){}
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        return view('backend.event.index', [
           'events' => $this->eventService->select(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        return view('backend.event.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventRequest $request) : RedirectResponse
    {
        $data = $request->validated();

        try {
            $data['image'] = $this->fileService->upload($request->file('image'), 'images');

            $this->eventService->create($data);

            return redirect()->route('panel.event.index')->with('success', 'Event has been created');
        } catch (\Exception $error) {
            $this->fileService->delete($data['image']);

            return redirect()->back()->with('error', $error->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid) : View
    {
        return view('backend.event.show', [
            'event' => $this->eventService->selectFirstBy('uuid', $uuid)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $uuid) : View
    {
        return view('backend.event.edit', [
            'event' => $this->eventService->selectFirstBy('uuid', $uuid)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventRequest $request, string $uuid) :RedirectResponse
    {
        $data = $request->validated();

        $getEvent = $this->eventService->selectFirstBy('uuid', $uuid);

        try {

            //jika upload
            if ($request->hasFile('image'))
            {
                //hapus gambar lama
                $this->fileService->delete($getEvent->image);

                //upload gambar baru
                $data['image'] = $this->fileService->upload($request->file('image'), 'images');

            }else{
                //jika tidak upload
                $data['image'] = $getEvent->image;
            }


            $this->eventService->update($data, $uuid);

            return redirect()->route('panel.event.index')->with('success', 'Event has been updated');
        } catch (\Exception $error) {
            $this->fileService->delete($data['image']);

            return redirect()->back()->with('error', $error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid): JsonResponse
    {
        $getMenu = $this->eventService->selectFirstBy('uuid', $uuid);
        $this->fileService->delete($getMenu->image);

        $getMenu->delete();

        return response()->json([
            'message' => 'Event has been deleted'
    ]);
    }
}
