<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\MenuRequest;
use App\Http\services\FileService;
use App\Http\services\MenuService;
use App\Http\Controllers\Controller;
use App\Http\services\CategoryService;

class MenuController extends Controller
{
    public function __construct(
        private FileService $fileService,
        private CategoryService $categoryService,
        private MenuService $menuService
        ){}
    public function index()
    {
        return view('backend.menu.index', [
            'menus' => $this->menuService->select(10),
            
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.menu.create', [
            'categories' => $this->categoryService->select()
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(MenuRequest $request)
    {
        $data = $request->validated();

        try {
            $data['image'] = $this->fileService->upload($request->file('image'), 'images');

            $this->menuService->create($data);

            return redirect()->route('panel.menu.index')->with('success', 'Menu has been created');
        } catch (\Exception $error) {
            $this->fileService->delete($data['image']);

            return redirect()->back()->with('error', $error->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        return view('backend.menu.show', [
            'menu' => $this->menuService->selectFirstBy('uuid', $uuid)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $uuid)
    {
        return view('backend.menu.edit', [
            'categories' => $this->categoryService->select(),
            'menu' => $this->menuService->selectFirstBy('uuid', $uuid)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MenuRequest $request, string $uuid)
    {
        $data = $request->validated();

        $getMenu = $this->menuService->selectFirstBy('uuid', $uuid);

        try {

            //jika upload
            if ($request->hasFile('image'))
            {
                //hapus gambar lama
                $this->fileService->delete($getMenu->image);

                //upload gambar baru
                $data['image'] = $this->fileService->upload($request->file('image'), 'images');

            }else{
                //jika tidak upload
                $data['image'] = $getMenu->image;
            }


            $this->menuService->update($data, $uuid);

            return redirect()->route('panel.menu.index')->with('success', 'menu has been updated');
        } catch (\Exception $error) {
            $this->fileService->delete($data['image']);

            return redirect()->back()->with('error', $error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        $getMenu = $this->menuService->selectFirstBy('uuid', $uuid);
        $this->fileService->delete($getMenu->image);

        $getMenu->delete();

        return response()->json([
            'message' => 'Menu has been deleted'
    ]);
    }
}
