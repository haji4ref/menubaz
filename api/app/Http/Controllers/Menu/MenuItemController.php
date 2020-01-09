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

        $gallery = Gallery::saveAndStore($request->file('image'), auth()->user()->id);

        $item->gallery()->associate($gallery);

        $item->save();

        return $item;
    }

    public function show($id)
    {
        return MenuItem::find($id);
    }
}
