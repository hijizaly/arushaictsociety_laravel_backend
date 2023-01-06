<?php

namespace App\Http\Resources;

use App\Models\MembersOtherSkills;
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
        $otherSkills=MembersOtherSkills::where('member_id',$this->id)->get();
        $otherSkills->map(function ($item,$key){
            $item["other_occupation_name"]=Skills::find( $item["other_occupation_id"])['name'];;
        });
        return [
            'id'=>$this->id,
            'member_fullname'=>$this->name,
            'member_email'=>$this->email,
            'member_phone'=>$this->phoneNumber,
            'occupation'=>Skills::find($this->occupation_id)['name'],
            'date Of birth'=>$this->dob,
            'other_skills'=>$otherSkills
        ];

    }
}
