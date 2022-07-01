<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
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
            'data'    => [
                'code'          => $this->code,
                'name'          => $this->name,
                'create_at'     => $this->created_at,
                'creator_name'  => $this->user->name,
            ],
            'message' => 'ایجاد اتاق با موفقیت انجام شد.',
            'status'  => 200,

        ];
    }
}
