<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class test extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($data)
    {
        $data;
        return [
            'data' => $data['name'],
            // 'age' => $data['age'],
            // 'name' => $data['name'],
            // 'job' => $data['job']
        ];
    }
}
