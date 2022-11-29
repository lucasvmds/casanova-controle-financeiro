<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Segment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
    ];

    protected $appends = [
        'active',
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public static function getAll(bool $with_trashed = false): Collection
    {
        /** @var Builder */
        $builder = $with_trashed ? static::withTrashed() : static::query();
        return $builder->orderBy('name')
                    ->get([
                        'id',
                        'name',
                        'deleted_at',
                    ]);
    }

    protected function active(): Attribute
    {
        return new Attribute(
            get: fn(): bool => !((bool) $this->deleted_at),
        );
    }
}
