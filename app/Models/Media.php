<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'filename',
        'filepath',
        'type',
        'uploaded_at',
        'post_id',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function getFileUrlAttribute()
    {
        return asset('uploads/' . $this->filename);
    }
}