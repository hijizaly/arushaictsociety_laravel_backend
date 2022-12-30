<?php

namespace App\Http\Resources;

use App\Models\Skills;
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
        $skillId=$this->occupation_id;
        $skill_name=Skills::find($skillId);
        return [
            'id'=>$this->id,
            'member_fullname'=>$this->name,
            'member_email'=>$this->email,
            'member_phone'=>$this->phoneNumber,
            'occupation'=>$skill_name['name'],
            'date Of birth'=>$this->dob

        ];

    }
}
