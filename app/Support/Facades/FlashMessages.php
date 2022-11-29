<?php

declare(strict_types=1);

namespace App\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static self success(string $content)
 * @method static self warning(string $content)
 * @method static self error(string $content)
 * @method static self shareNow()
 * @method static array getSharedMessages()
 */
class FlashMessages extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \App\Support\FlashMessages::class;
    }
}