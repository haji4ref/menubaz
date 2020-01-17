<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Gallery extends Model {

    protected $fillable = ['url', 'name', 'user_id'];

    protected $appends = ['publicUrl'];

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

    public function deleteFile()
    {
        if(File::exists(storage_path('app/' . $this->url))) {
            File::delete(storage_path('app/' . $this->url));
        }

        return $this;
    }

    public function myUpdate($file, $name = null)
    {
        $path = $file->store('public/images/users/' . $this->user_id . '/foods');

        $this->update([
            'name' => $name,
            'url'  => $path,
        ]);

        return $this;
    }

    public function getPublicUrlAttribute()
    {
        return '/' . str_replace('public', 'storage', $this->url);
    }
}
