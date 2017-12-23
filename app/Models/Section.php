<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $guarded = [];

    /**
     * Get the post that owns the comment.
     */
    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    /**
     * Get the comments for the blog post.
     */
    public function data()
    {
        return $this->hasMany(Data::class);
    }
}
