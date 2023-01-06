<?php

namespace App\Http\Resources;

use App\Models\Skills;
use Illuminate\Http\Resources\Json\JsonResource;

class MembersOtherSkillsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        dd($this);

        return [
            'member_id'=>$this->member_id,
            'other_skill'=>Skills::find($this->other_occupation_id)['name'],
            'created_at'=>$this->created_at
        ];

//        return parent::toArray($request);
    }
}
