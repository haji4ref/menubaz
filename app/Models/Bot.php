<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bot extends Model {

    protected $fillable = ['id', 'first_name', 'token', 'name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contactUsMsg()
    {
        return $this->hasOne(ContactUsMessage::class);
    }
}
