<?php

namespace App\Http\Requests;

class staffRequest
{
    public function rules(): array
    {
        return [
            'uuid' => ['required'],
            'name' => ['required'],
            'dni' => ['required'],
            'lastname' => ['required'],
            'startDate' => ['required', 'date'],
            'endDate' => ['required', 'date'],
            'updateDate' => ['required', 'date'],
            'creationDate' => ['required', 'date'],
            'image' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
