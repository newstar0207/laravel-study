<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Blog extends JsonResource
{
    /**
     * Transform the resource into an array.
     * 라우터나 컨트롤러에서도 데이터를 반환 할 수 있음
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'created_at' => $this->created_at->format('m/d/Y'),
            'updated_at' => $this->updated_at->format('m/d/Y'),
        ];
    }
}
