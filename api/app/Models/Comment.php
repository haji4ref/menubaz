<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    protected $fillable = ['body', 'seen'];

    protected $casts = [
        'seen' => 'boolean'
    ];

    protected $visible = ['id', 'seen', 'body', 'created_at'];

    /**
     * Get the owning commentable model.
     */
    public function commentable()
    {
        return $this->morphTo();
    }
}
