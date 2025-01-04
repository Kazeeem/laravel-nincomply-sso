<?php

namespace Eximius\Nincomply\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Eximius\Nincomply\Nincomply
 */
class Nincomply extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Eximius\Nincomply\Nincomply::class;
    }
}
