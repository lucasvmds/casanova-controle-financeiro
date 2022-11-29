<?php

declare(strict_types=1);

namespace App\Http\Requests\Transaction;

use App\Enums\TransactionType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'group_id' => 'nullable|string',
            'segment_id' => 'required|exists:segments,id',
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'type' => [
                'required',
                new Enum(TransactionType::class),
            ],
            'pending' => 'required|boolean',
            'valid_at' => [
                Rule::requiredIf($this->input('pending')),
            ],
            'created_at' => 'nullable|date',
        ];
    }
}
