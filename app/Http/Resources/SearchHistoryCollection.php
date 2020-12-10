<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Property;

class SearchHistoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        // return parent::toArray($request);
        // Post::collection($this->whenLoaded('posts'))
        
        return parent::toArray([
                    "id"=> $this->id,
                    "user_id"=> $request->user_id,
                    "property_id_3"=> $this->property_id,
                    "created_at"=> $request->created_at,
                    "updated_at"=> $request->updated_at
        ]);
    }
}
