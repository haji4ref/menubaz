<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Model;

class MenuCategory extends Model
{
    protected $fillable = ['name'];

    public function items()
    {
        return $this->hasMany(MenuItem::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
