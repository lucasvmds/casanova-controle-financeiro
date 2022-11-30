<?php

declare(strict_types=1);

namespace App\Http\Requests\Extract;

use Illuminate\Foundation\Http\FormRequest;

class ShowRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'initial_date' => 'required|date',
            'final_date' => 'required|date',
        ];
    }
}
