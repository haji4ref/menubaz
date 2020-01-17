<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller {

    public function show($id, Request $request)
    {
        return Gallery::findOrFail($id);
    }
}
