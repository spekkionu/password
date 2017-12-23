<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Data extends Model
{
    protected $guarded = [];

    /**
     * Get the post that owns the comment.
     */
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * @param array|null $value
     *
     * @return array
     */
    public function getDataAttribute($value)
    {
        if (null === $value) {
            return [];
        }

        return json_decode(Crypt::decryptString($value), true);
    }

    /**
     * @param array|null $value
     */
    public function setDataAttribute($value)
    {
        if (null === $value) {
            $value = [];
        }
        if ( ! is_array($value)) {
            throw new \InvalidArgumentException('Invalid data value');
        }
        $this->attributes['data'] = Crypt::encryptString(json_encode($value));
    }
}
