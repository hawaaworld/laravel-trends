<?php

namespace Hawaaworld\Trends\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Energy extends Model
{
    protected $fillable = ['amount'];

    public function energiser(): MorphTo
    {
        return $this->morphTo();
    }
}
