<?php

namespace App\Models\Menu;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model {

    protected $fillable = ['name', 'price', 'bolded_description', 'description','gallery_id'];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }
}
