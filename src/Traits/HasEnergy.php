<?php

namespace Hawaaworld\Trends\Traits;

use Hawaaworld\Trends\Jobs\AddEnergy;
use Hawaaworld\Trends\Models\Energy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/* @mixin Model */
trait HasEnergy
{
    public function addEnergy(float $amount = 1.0): void
    {
        if (in_array(app('request')->ip(), config('trends.ip_blacklist', []), true)) {
            return;
        }

        AddEnergy::dispatch($this, $amount);
    }

    public function energy(): MorphOne
    {
        return $this->morphOne(Energy::class, 'energiser');
    }

    protected function energyAmount(): Attribute
    {
        return Attribute::get(fn () => $this->energy->amount);
    }
}
