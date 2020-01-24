<?php

namespace App\Models\Menu;

use App\Models\Comment;
use App\Models\Gallery;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model {

    protected $fillable = ['name', 'price', 'bolded_description', 'description', 'gallery_id'];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    public function menuCategory()
    {
        return $this->belongsTo(MenuCategory::class);
    }

    /**
     * Get all of the menu items's comments.
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function ownerName()
    {
        return $this->menuCategory
            ->menu
            ->user
            ->name;
    }

    public function deleteGallery()
    {
        if($this->gallery) {
            $this->gallery->deleteFile();

            $this->gallery->delete();
        }

        return $this;
    }

}
