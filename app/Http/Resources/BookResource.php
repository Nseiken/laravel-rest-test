<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return  [
            'isbn' => $this->isbn,
            'book_title' => $this->book_title,
            'cover_url' => $this->cover_url,
            'created' => $this->created_at,
            'authors'    => AuthorResource::collection($this->whenLoaded('authors'))
        ];
    }
}
