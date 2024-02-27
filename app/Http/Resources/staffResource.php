<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

/** @mixin \App\Models\staff */
class staffResource
{
    public function toArray(Request $request): array
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'uuid' => $this->uuid,
            'name' => $this->name,
            'dni' => $this->dni,
            'lastname' => $this->lastname,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'updateDate' => $this->updateDate,
            'creationDate' => $this->creationDate,
            'image' => $this->image,
        ];
    }
}
