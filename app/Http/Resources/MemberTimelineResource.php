<?php

namespace App\Http\Resources;

use App\Models\Skills;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberTimelineResource extends JsonResource
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
        //Skills::find($this->occupation_id)['name']
        return [
            'id'=>$this->id,
            'type'=>($this->old_occupation_id==null) ? 'other' : 'main',
            'old_occupation_id'=>$this->old_occupation_id=($this->old_occupation_id==null) ? null : Skills::find($this->old_occupation_id)['name'],
            'new_occupation_id'=>$this->new_occupation_id=($this->new_occupation_id==null) ? null : Skills::find($this->new_occupation_id)['name'],
            'created_at'=>$this->created_at,

        ];
    }
}
