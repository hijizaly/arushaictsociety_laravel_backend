<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContentsResource extends JsonResource
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
        $result = [
            'id'=>$this->id,
            'componentMainId'=>$this->component_id[0],
            'componentId'=>$this->component_id,
            'contentHead'=>$this->content_head,
            'contentBody'=>$this->content_body,
            'contentImage'=>$this->content_image==null?null:url(env('CONTENT_FILES_DIR').'/'.$this->content_image),
//            'contentImage'==null?null:'contentImage'=>url(env('CONTENT_FILES_DIR').'/'.$this->content_image),
//            'contentImage'=>url(env('CONTENT_FILES_DIR').'/'.$this->content_image),
            'created_at'=>$this->created_at,
        ];
        return $result;
    }

    public function jsonOptions()
    {
        return JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT;
    }
}
