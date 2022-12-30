<?php

namespace App\Http\Controllers;

use App\Http\Requests\{StoreMembersRequest, UpdateMembersRequest};
use App\Http\Resources\{MembersResource, SkillsResource};
use App\Models\{Members, MemberTimeline};

//use http\Env\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

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
        return \response()->json(['message'=>'login successfully','accessToken'=>$token]);
    }
    public function me(){
        return response()->json(auth()->guard('members-api' )->user());
    }
    public function memberLogout(){
        auth()->guard('members-api')->logout();
        return response()->json(['message'=>'Successfully logged out']);
    }
    public function testEnd(){
        return response()->json(['message'=>'Successfully hittingX']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $allMembers=members::all();
//        print_r($allMembers['occupation_id']);

        return MembersResource::collection($allMembers);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMembersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMembersRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Members  $members
     * @return \Illuminate\Http\Response
     */
    public function show(Members $members)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Members  $members
     * @return \Illuminate\Http\Response
     */
    public function edit(Members $members)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMembersRequest  $request
     * @param  \App\Models\Members  $members
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateMembersRequest $request, Members $members,$id)
    {
        $payload = auth()->payload();
//        dd($payload->toArray());

        if($payload('id') != $id){
            return \response()->json(['message'=>'Wrong Members Id 👋🏼']);
        }else{
            $oldMemberUpdate= Members::find($id);
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
                $membersSkillUpdateTimeline = MemberTimeline::create([
                    'member_id' => $oldMemberUpdate['id'],
                    'old_occupation_id'=>$oldMemberUpdate['occupation_id'],
                    'new_occupation_id'=>$request->occupation_id
                ]);
            }

            return new MembersResource($oldMemberUpdate);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Members  $members
     * @return \Illuminate\Http\Response
     */
    public function destroy(Members $members)
    {
        //

    }
}
