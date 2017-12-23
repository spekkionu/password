<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $guarded = [];

    /**
     * Get the comments for the blog post.
     */
    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    /**
     * @param Builder $query
     * @param string  $search
     *
     * @return mixed
     */
    public function scopeSearch(Builder $query, string $search = '')
    {
        return $query->where(function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
            $query->orWhere('domain', 'LIKE', '%' . $search . '%');
        });
    }
}
