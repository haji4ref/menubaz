<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\CreateMenuCategoryRequest;

class MenuController extends Controller {

    public function showUserMenu()
    {
        $menus = auth()->user()->menus();
        if($menus->exists()) {
            return $menus->first();
        } else {
            $menu = auth()->user()->menus()->create();

            return $menu;
        }
    }

    public function menuCategories($id)
    {
        return auth()->user()->menus()->find($id)->categories()->get();
    }

    public function createMenuCategory(CreateMenuCategoryRequest $request, $id)
    {
        return auth()->user()->menus()->find($id)->categories()->create([
            'name' => $request->get('name')
        ]);
    }
}
