<?php

namespace App\Models\Menu;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model {

    public function categories()
    {
        return $this->hasMany(MenuCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
