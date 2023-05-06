<?php

namespace App\Http\Resources;

use App\Libraries\Hashids\Hashids;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomAttributeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
        ];
    }
}
