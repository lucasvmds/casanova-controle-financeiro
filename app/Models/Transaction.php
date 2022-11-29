<?php

namespace App\Models;

use App\Actions\Transaction\SumGroupedAmount;
use App\Enums\TransactionType;
use App\Models\Casts\Currency;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'segment_id',
        'group_id',
        'description',
        'type',
        'amount',
        'pending',
        'valid_at',
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'segment_name',
    ];

    protected $casts = [
        'amount' => Currency::class,
        'pending' => 'boolean',
        'valid_at' => 'datetime',
        'last_transaction_date' => 'datetime',
    ];

    public function segment(): BelongsTo
    {
        return $this->belongsTo(Segment::class);
    }

    protected function segmentName(): Attribute
    {
        return new Attribute(
            get: fn(): string => $this->segment()->first(['name'])->name,
        );
    }

    public static function countPending(): int
    {
        return static::query()
                    ->where('pending', true)
                    ->count(['id']);
    }

    public static function getAllByGroupId(string $group_id): array
    {
        $transactions = static::query()
                                ->where('group_id', $group_id)
                                ->orderBy('created_at', 'desc')
                                ->get();
        $total_in = SumGroupedAmount::sum(TransactionType::IN, $transactions);
        $total_out = SumGroupedAmount::sum(TransactionType::OUT, $transactions);
        return [
            'transactions' => $transactions,
            'total_in' => SumGroupedAmount::formatCurrency($total_in),
            'total_out' => SumGroupedAmount::formatCurrency($total_out),
            'total_profit' => SumGroupedAmount::formatCurrency(
                $total_in - $total_out
            ),
        ];
    }
}
