<?php

namespace Hawaaworld\Trends\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphOne;

interface Energy
{
    public function addEnergy(float $amount = 1.0): void;

    public function energy(): MorphOne;
}
