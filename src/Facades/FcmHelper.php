<?php

namespace AhmedHegazy\FcmHelper\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \AhmedHegazy\FcmHelper\FcmHelper
 */
class FcmHelper extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \AhmedHegazy\FcmHelper\FcmHelper::class;
    }
}
