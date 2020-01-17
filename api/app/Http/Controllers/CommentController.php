<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Menu\MenuItem;
use Illuminate\Http\Request;

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

    public function seen($id, Request $request)
    {
        $comment = Comment::findOrFail($id);

        $comment->update([
            'seen' => $request->get('seen') ? 1 : 0
        ]);

        $comment->save();

        return $comment;
    }
}
