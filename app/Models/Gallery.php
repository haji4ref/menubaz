<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model {

    protected $fillable = ['url', 'name', 'user_id'];

    public static function saveAndStore($file, $user_id, $name = null)
    {
        $path = $file->store('public/images/users/' . $user_id . '/foods');

        $gallery = Gallery::create([
            'name'    => $name,
            'url'     => $path,
            'user_id' => $user_id
        ]);

        return $gallery;
    }

    public function getPublicUrlAttribute()
    {
        return '/' . str_replace('public', 'storage', $this->url);
    }
}
