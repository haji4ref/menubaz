<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = ['chat_id','first_name','last_name','user_name'];

    public function bots()
    {
        return $this->belongsToMany(Bot::class)->withPivot(['bot_id','member_id','last_data']);
    }
}
