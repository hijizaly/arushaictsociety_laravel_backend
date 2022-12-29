<?php

namespace App\Http\Controllers;

use App\Http\Resources\SkillsResource;
use App\Models\Skills;
use Illuminate\Http\Request;

class SkillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return SkillsResource::collection(Skills::all());
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
//        dd($request);
        $newSkill_ = Skills::create(['name' => $request->skill_name,
            'abbreviation' => $request->abbreviation]);
//        return SkillsResource::collection($newSkill_);
        return [$newSkill_];
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Skills $skills
     * @return \Illuminate\Http\Response
     */
    public function show(Skills $skills)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Skills $skills
     * @return \Illuminate\Http\Response
     */
    public function edit(Skills $skills)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Skills $skills
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Skills $skills, $id)
    {
        $skillsToUpdate = Skills::find($id);
        $skillsToUpdate->update([
            'name' => $request->skill_name,
            'abbreviation' => $request->abbreviation]);
        return new SkillsResource($skillsToUpdate);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Skills $skills
     * @return \Illuminate\Http\Response
     */
    public function destroy(Skills $skills)
    {
        //
    }
}
