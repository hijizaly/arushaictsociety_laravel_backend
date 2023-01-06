<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\{StoreMembersRequest, UpdateMembersRequest};
use App\Http\Resources\{MembersResource, SkillsResource};
use App\Models\{Members, MemberTimeline};
use App\Http\Controllers\MemberTimelineController;

//use http\Env\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use function response;

class MembersController extends Controller
{
    public function membersRegistration(Request $request){
//        dd($request);
        $newMember=Members::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'address'=>$request->address,
            'dob'=>$request->dob,
            'status'=>$request->status,
            'occupation_id'=>$request->occupation_id,
            'role'=>$request->role,
            'phoneNumber'=>$request->phone
        ]);
        if($newMember){
            return response()->json([$newMember,'status'=>true]);
        }else{
            return response()->json(['status'=>false]);
        }
    }

    public function memberLogin(Request $request){
        $adminCredentials=request(['email','password']);

        if (!$token=auth()->guard('members-api')->attempt($adminCredentials)){
            return response()->json(['error'=>'Unauthorized'],401);
        }
        return response()->json(['message'=>'login successfully','accessToken'=>$token]);
    }
    public function me(){
        return response()->json(auth()->guard('members-api' )->user());
    }
    public function memberLogout(){
        auth()->guard('members-api')->logout();
        return response()->json(['message'=>'Successfully logged out']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $allMembers=members::all();
        return MembersResource::collection($allMembers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMembersRequest $request
     * @return Response
     */
    public function store(StoreMembersRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Members $members
     * @return Response
     */
    public function show(Members $members,$id)
    {
        $memberId = auth()->payload()('id');
        $memberDetailes=Members::find($memberId);
        if($memberId==$id){


//            return \response()->json(['data' => $memberDetailes]);
            return new MembersResource($memberDetailes);

        }else{
//            return \response()->json(['data' ]);
            return \response()->json(['message'=>'Unauthorized'])->setStatusCode(401);

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Members $members
     * @return Response
     */
    public function edit(Members $members)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateMembersRequest $request
     * @param Members $members
     * @return JsonResponse
     */
    public function update(UpdateMembersRequest $request, Members $members,$id)
    {
        $payload = auth()->payload();
//        dd($payload->toArray());

        if($payload('id') != $id){
            return response()->json(['message'=>'Wrong Members Id 👋🏼']);
        }else{
            $oldMemberUpdate= Members::find($id);
            $oldOccupationId=$oldMemberUpdate['occupation_id'];
            if($oldMemberUpdate['occupation_id']==$request->occupation_id){
                $oldMemberUpdate->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'address' => $request->address,
                    'dob' => $request->dob,
                    'status' => $request->status,
                    'occupation_id' => $request->occupation_id,
                    'role' => $request->role,
                    'phoneNumber' => $request->phone
                ]);
            }else{
                $oldMemberUpdate->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'address' => $request->address,
                    'dob' => $request->dob,
                    'status' => $request->status,
                    'occupation_id' => $request->occupation_id,
                    'role' => $request->role,
                    'phoneNumber' => $request->phone
                ]);
//                $membersSkillUpdateTimeline = MemberTimeline::create([
//                    'member_id' => $oldMemberUpdate['id'],
//                    'old_occupation_id'=>$oldOccupationId,
//                    'new_occupation_id'=>$request->occupation_id
//                ]);
                $timeLineResult=App('App\Http\Controllers\MemberTimelineController')->create($payload('id'),$request->occupation_id,$oldOccupationId);
//                echo $timeLineResult;
            }

            return new MembersResource($oldMemberUpdate);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Members $members
     * @return Response
     */
    public function destroy(Members $members)
    {
        //

    }
    public function unauthorized(): JsonResponse
    {
                    return \response()->json(['message'=>'Unauthorized'])->setStatusCode(401);
//                    return \response()->setStatusCode(401);
    }
}
