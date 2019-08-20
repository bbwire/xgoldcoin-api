<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTrait;
use App\Models\CandidateProject;
use Illuminate\Http\Request;

class CandidateProjectController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $candidateProjects = CandidateProject::with('candidate')->get();

        return $this->successResponse($candidateProjects);
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

        $results = CandidateProject::create($data);

        $this->successResponse($results, 'Project added');
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $candidateProject = CandidateProject::with('candidate')->get()->first();

        return $this->successResponse($candidateProject);
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

        $candidateProject = CandidateProject::findOrFail($id);

        $candidateProject->update($data);

        return $this->updateResponse('Project updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $candidateProject = CandidateProject::findOrFail($id);

        $candidateProject->delete();

        return $this->updateResponse('Project trashed successfully!');
    }
}
