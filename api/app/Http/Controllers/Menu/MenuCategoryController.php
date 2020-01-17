<?php

namespace App\Http\Controllers\Menu;

use App\Http\Requests\Menu\CreateMenuItemRequest;
use App\Models\Gallery;
use App\Models\Menu\MenuCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuCategoryController extends Controller {

    public function items($id)
    {
        return MenuCategory::find($id)->items()->with('comments')->get();
    }

    public function createItem($id, CreateMenuItemRequest $request)
    {
        $category = MenuCategory::find($id);

        $item = $category->items()->create($request->all());

        $gallery = Gallery::saveAndStore($request->file('image'), auth()->user()->id);

        $item->gallery()->associate($gallery);

        $item->save();

        return $item;
    }
}
