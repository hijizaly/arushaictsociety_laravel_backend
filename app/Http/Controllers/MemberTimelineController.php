<?php

namespace App\Http\Controllers;

use App\Http\Resources\MemberTimelineResource;
use App\Models\MemberTimeline;
use Illuminate\Http\Request;

class MemberTimelineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $memberId = auth()->payload()('id');
        $allMemberTimeline=MemberTimeline::where('member_id',$memberId)->orderBy('created_at','DESC')->get();

        return MemberTimelineResource::collection($allMemberTimeline);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return bool
     */
    public function create($memberId,$new_occupation_id,$old_occupation_id=null)
    {
        $membersSkillUpdateTimeline = MemberTimeline::create([
            'member_id' => $memberId,
            'old_occupation_id'=>$old_occupation_id,
//            'old_occupation_id'=>(empty($old_occupation_id))? null : $old_occupation_id,
            'new_occupation_id'=>$new_occupation_id
        ]);
        if($membersSkillUpdateTimeline){
            return true;
        }else return false;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MemberTimeline  $memberTimeline
     * @return \Illuminate\Http\Response
     */
    public function show(MemberTimeline $memberTimeline)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MemberTimeline  $memberTimeline
     * @return \Illuminate\Http\Response
     */
    public function edit(MemberTimeline $memberTimeline)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MemberTimeline  $memberTimeline
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MemberTimeline $memberTimeline)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MemberTimeline  $memberTimeline
     * @return \Illuminate\Http\Response
     */
    public function destroy(MemberTimeline $memberTimeline)
    {
        //

    }

    public function removeOtherSkills($memberId,$skillId)
    {

//        $ifTheyExisted = MemberTimeline::where('member_id',$memberId)->where('new_occupation_id',$skillId)->delete();
        MemberTimeline::where('member_id',$memberId)->where('new_occupation_id',$skillId)->delete();
//        if(!empty($ifTheyExisted)){
//            $ifTheyExisted->delete();
//        }
    }
}
