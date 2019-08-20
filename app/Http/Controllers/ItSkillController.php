<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTrait;
use App\Models\ItSkill;
use Illuminate\Http\Request;

class ItSkillController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $itSkills = ItSkill::with('candidate')->get();

        return $this->successResponse($itSkills);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $results = ItSkill::create($data);

        return $this->successResponse($results, 'New skill added');
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $itSkill = ItSkill::with('candidate')->where('id', $id)->get()->first();

        return $this->successResponse($itSkill);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $itSkill = ItSkill::findOrFail($id);

        $itSkill->update($data);

        return $this->updateResponse('Skill updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $itSkill = ItSkill::findOrFail($id);

        $itSkill->delete();

        return $this->updateResponse('Skill trashed successfully!');
    }
}
