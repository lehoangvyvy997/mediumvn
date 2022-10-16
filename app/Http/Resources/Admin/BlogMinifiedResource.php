<?php

namespace App\Http\Resources\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogMinifiedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'status' => Str::headline($this->status),
            'slug' => $this->slug,
            'thumbnail' => $this->thumbnail,
            'email' => $this->author->email,
            'author' => $this->author->name,
            'author_image' => $this->author->profile_image,
            'created_at' => $this->created_at,
        ];
    }
}
