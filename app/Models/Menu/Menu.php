<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    public function categories()
    {
        return $this->hasMany(MenuCategory::class);
    }
}
