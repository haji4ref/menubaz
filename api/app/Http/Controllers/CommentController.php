<?php

namespace App\Http\Controllers;

use App\Models\Menu\MenuItem;

class CommentController extends Controller {

    public function submitItem($item_id)
    {

    }

    public function saveItem($item_id, $body)
    {
        $item = MenuItem::find($item_id)->comments()->create([
            'body' => $body
        ]);

        return $item;
    }
}
