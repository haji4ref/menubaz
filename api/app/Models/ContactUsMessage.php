<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactUsMessage extends Model {

    protected $fillable = ['msg'];

    public function bot()
    {
        return $this->belongsTo(Bot::class);
    }
}
