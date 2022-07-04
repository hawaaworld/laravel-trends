<?php

namespace Hawaaworld\Trends\Facades;

use Illuminate\Support\Facades\Facade;

class Trends extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'trends';
    }
}
