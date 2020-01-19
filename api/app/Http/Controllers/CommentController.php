<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Menu\MenuItem;
use App\Models\User;
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

    public function saveUser($user_id, $body)
    {
        $user = User::find($user_id)->comments()->create([
            'body' => $body
        ]);

        return $user;
    }

    public function getUserComments()
    {
        $user = auth();

        return $user->comments;
    }

    public function getUnseenUserComments()
    {
        return auth()->user()->comments()->where('seen', '=', false)->count();
    }

    public function userComments()
    {
        return auth()->user()->comments;
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
