<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class staffResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'dni' => $this->dni,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'updateDate' => $this->updateDate,
            'creationDate' => $this->creationDate,
            'image' => $this->image,
            'role' => $this->role,
        ];
    }
}