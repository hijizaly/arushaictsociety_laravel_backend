<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MembersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
            'id'=>$this->id,
            'member_fullname'=>$this->name,
            'member_email'=>$this->email,
            'member_phone'=>$this->phoneNumber,
            'occupation'=>$this->occupation_id,
            'date Of birth'=>$this->dob

        ];

    }
}
