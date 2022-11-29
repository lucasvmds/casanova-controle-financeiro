<?php

declare(strict_types=1);

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'pending' => 'required|boolean',
            'valid_at' => [
                Rule::requiredIf($this->input('pending')),
            ],
            'created_at' => 'nullable|date',
        ];
    }
}
