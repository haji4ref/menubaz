<?php

namespace App\Http\Controllers\Menu;

use App\Http\Requests\Menu\CreateMenuItemRequest;
use App\Models\Gallery;
use App\Models\Menu\MenuCategory;
use App\Http\Controllers\Controller;
use App\Models\Menu\MenuItem;

class MenuItemController extends Controller {

    public function createItem($id, CreateMenuItemRequest $request)
    {
        $category = MenuCategory::find($id);

        $item = $category->items()->create($request->all());

        if($request->has('image')) {
            $gallery = Gallery::saveAndStore($request->file('image'), auth()->user()->id);

            $item->gallery()->associate($gallery);

            $item->save();
        }

        return $category->items()->with('comments')->get();
    }

    public function show($id)
    {
        return MenuItem::find($id);
    }

    public function delete($id)
    {
        $item = MenuItem::with('gallery')->findOrFail($id);

        $item->deleteGallery();

        $category = $item->menuCategory;

        $item->delete();

        return $category->items()->with('comments')->get();
    }

    public function edit($id, CreateMenuItemRequest $request)
    {
        $menuItem = MenuItem::with('comments')->findOrFail($id);

        $menuItem->update($request->all());

        if($menuItem->gallery && $request->has('image')) {
            $gallery = $menuItem->gallery->deleteFile()->myUpdate($request->file('image'));
        } elseif( ! $menuItem->gallery && $request->has('image')) {
            $gallery = Gallery::saveAndStore($request->file('image'), auth()->user()->id);

            $menuItem->gallery()->associate($gallery);

            $menuItem->save();
        }

        return $menuItem->menuCategory->items()->with('comments')->get();
    }
}
