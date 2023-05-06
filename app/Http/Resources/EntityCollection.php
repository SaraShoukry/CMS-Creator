<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EntityCollection extends ResourceCollection
{
  public function toArray($request)
  {
      return [
          'data' => EntityResource::collection($this->collection),
          'pagination' => [
              'total' => $this->total(),
              'count' => $this->count(),
              'number_per_page' => $this->perPage(),
              'page' => $this->currentPage(),
              'last_page' => $this->lastPage(),
          ],

      ];
  }
}
