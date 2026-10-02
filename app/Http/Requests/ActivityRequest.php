<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

abstract class ActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:5', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
            'activity_date' => ['required', 'date'],

            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'code' => [
                'required',
                'string',
                'max:30',
                Rule::unique('activities', 'code')
                    ->ignore($this->route('activity')),
            ],

            'location' => [
                'required',
                'string',
                'max:150',
            ],

            'capacity' => [
                'required',
                'integer',
                'min:1',
                'max:500',
            ],
        ];
    }
}
