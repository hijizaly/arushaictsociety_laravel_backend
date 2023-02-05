<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMembersOtherSkillsRequest;
use App\Http\Requests\UpdateMembersOtherSkillsRequest;
use App\Http\Resources\MembersOtherSkillsResource;
use App\Models\MembersOtherSkills;
use App\Models\Skills;
use http\Env\Response;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;


class MembersOtherSkillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $memberId = auth()->payload()('id');
        $allMemberSkills = MembersOtherSkills::where('member_id', $memberId)->get();
        return MembersOtherSkillsResource::collection($allMemberSkills);
//        return \response()->json(['m' => $allMemberSkills]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function create(Request $request)
    {
        $arrayOfResults = [];
        $memberId = auth()->payload()('id');

//        $targetSkill = skills::find($request->occupation_id);
//        $targetSkill = Skills::all();
        $targetSkill = Skills::findMany($request->occupation_id);

//            dd($request);
//        return \response()->json($request);


        function otherSkillsCreate($eachOccupationId)
        {
            $newOtherSkills = MembersOtherSkills::create([
                'member_id' => auth()->payload()('id'),
                'other_occupation_id' => $eachOccupationId
            ]);
            App('App\Http\Controllers\MemberTimelineController')->create(auth()->payload()('id'), $eachOccupationId);
            return $newOtherSkills;
        }

        if (count($targetSkill) != count($request->occupation_id)) {
            return \response()->json(['message' => 'Some of Skills Id\'s is Wrong👋🏼']);
        } else {
            if (is_array($request->occupation_id)) {
                foreach ($request->occupation_id as $eachOccupationId) {
                    $ifTheyExisted = MembersOtherSkills::where('member_id', $memberId)->where('other_occupation_id', $eachOccupationId)->first();
                    if (empty($ifTheyExisted)) {
                        array_push($arrayOfResults, otherSkillsCreate($eachOccupationId));
                    } else {
                        array_push($arrayOfResults, $ifTheyExisted);
                    }
                }
            } else {
                return \response()->json(['message' => 'Skills Id\'s Must be An Array 👋🏼']);

            }
            return MembersOtherSkillsResource::collection($arrayOfResults);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreMembersOtherSkillsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMembersOtherSkillsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\MembersOtherSkills $membersOtherSkills
     * @return \Illuminate\Http\Response
     */
    public function show(MembersOtherSkills $membersOtherSkills)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\MembersOtherSkills $membersOtherSkills
     * @return \Illuminate\Http\Response
     */
    public function edit(MembersOtherSkills $membersOtherSkills)
    {

        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateMembersOtherSkillsRequest $request
     * @param \App\Models\MembersOtherSkills $membersOtherSkills
     * @return \Illuminate\Http\Response
     */
    public function update_(UpdateMembersOtherSkillsRequest $request, MembersOtherSkills $membersOtherSkills)
    {
        //
        return \response()->json($request);


    }

    public function update(Request $request)
    {
        $newOccupationId = array_unique($request->occupation_id);
        function otherSkillsCreate($eachOccupationId)
        {
            $newOtherSkills = MembersOtherSkills::create([
                'member_id' => auth()->payload()('id'),
                'other_occupation_id' => $eachOccupationId
            ]);
            App('App\Http\Controllers\MemberTimelineController')->create(auth()->payload()('id'), $eachOccupationId);
            return $newOtherSkills;
        }
        function otherSkillsDestroy($eachOccupationId)
        {
            $newOtherSkills = MembersOtherSkills::destroy($eachOccupationId);
            App('App\Http\Controllers\MemberTimelineController')->removeOtherSkills(auth()->payload()('id'), $eachOccupationId);
            return $newOtherSkills;
        }

        if (is_array($newOccupationId)) {
            $allSkill = Skills::findMany($newOccupationId);

            if (count($allSkill) != count($newOccupationId)) {
                return \response()->json(['message' => 'Some of Skills Id\'s is Wrong👋🏼']);
            } else {

                $otherSkillAvailable = MembersOtherSkills::where('member_id', auth()->payload()('id'))->get();

                foreach ($otherSkillAvailable as $eachOtherSkillAvailable) {
                    if (in_array($eachOtherSkillAvailable['other_occupation_id'], $newOccupationId)) {

                    } else {
                        otherSkillsDestroy($eachOtherSkillAvailable['id']);
                    }
                    unset($newOccupationId[array_search($eachOtherSkillAvailable['other_occupation_id'], $newOccupationId)]);
                }
                foreach ($newOccupationId as $eachNewOccupationId) {
                    otherSkillsCreate($eachNewOccupationId);
                }
                $arrayOfResults=MembersOtherSkills::where('member_id', auth()->payload()('id'))->get();
                return \response()->json(['data' => $arrayOfResults]);
            }
        } else {
            return \response()->json(['message' => 'Skills Id\'s Must be An Array 👋🏼']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\MembersOtherSkills $membersOtherSkills
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(MembersOtherSkills $membersOtherSkills, Request $request)
    {
//        $targetSkill = skills::find($request->occupation_id);
        $targetSkill = Skills::findMany($request->occupation_id);
        $arrayOfResults = [];
        $memberId = auth()->payload()('id');


        if (count($targetSkill) != count($request->occupation_id)) {
            return \response()->json(['message' => 'Wrong Skill Id 👋🏼']);
        } else {
            if (is_array($request->occupation_id)) {
                foreach ($request->occupation_id as $eachOccupationId) {
//                    echo $eachOccupationId;
                    $ifTheyExisted = MembersOtherSkills::where('member_id', $memberId)->where('other_occupation_id', $eachOccupationId)->first();
                    if (!empty($ifTheyExisted)) {
                        $skillToDelete = $ifTheyExisted->delete();

                        App('App\Http\Controllers\MemberTimelineController')->removeOtherSkills(auth()->payload()('id'), $eachOccupationId);

                        array_push($arrayOfResults, $skillToDelete);
                    }
                }
            } else {
                return \response()->json(['message' => 'Skills Id\'s Must be An Array 👋🏼']);
            }
            return \response()->json(['data' => $arrayOfResults]);
//            return MembersOtherSkillsResource::collection($arrayOfResults);
        }
    }
}
