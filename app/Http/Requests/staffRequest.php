<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class staffRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array The validation rules.
     */

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'dni' => ['required'],
            'lastname' => ['required'],
            'email' => ['required'],
            'endDate' => ['required', 'date'],
            'updateDate' => ['required', 'date'],
            'creationDate' => ['required', 'date'],
            'image' => ['required'],
            'role' => ['required'],
            'isDelete' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
