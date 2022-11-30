<?php

declare(strict_types=1);

namespace App\Models\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use NumberFormatter;

class Currency implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function get($model, string $key, $value, array $attributes): string|false
    {
        $formater = new NumberFormatter('pt-BR', NumberFormatter::CURRENCY);
        return $formater->formatCurrency((float) $value, 'BRL');
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes): mixed
    {
        return $value;
    }

    public static function format(float $value): string
    {
        return (new self)
                    ->get(
                        '',
                        '',
                        $value,
                        []
                    );
    }
}
