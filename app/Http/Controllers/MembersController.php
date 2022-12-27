<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMembersRequest;
use App\Http\Requests\UpdateMembersRequest;
use App\Http\Resources\MembersResource;
use App\Http\Resources\SkillsResource;
use App\Models\Members;
//use http\Env\Request;
use App\Models\Skills;
use http\Env\Response;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return MembersResource::collection(members::all());

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
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMembersRequest $request, Members $members,$id)
    {
        $newMemberUpdate= Members::find($id);
        $newMemberUpdate->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'address'=>$request->address,
            'dob'=>$request->dob,
            'status'=>$request->status,
            'occupation_id'=>$request->occupation_id,
            'role'=>$request->role,
            'phoneNumber'=>$request->phone
        ]);
        $skillId=$newMemberUpdate['occupation_id'];
        $skill=Skills::find($skillId);

//        echo $skill['name'];
        $newMemberUpdate=$newMemberUpdate['occupation_id']=$skill['name'];
        echo $newMemberUpdate;
//        return new MembersResource($newMemberUpdate);
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
