<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTrait;
use App\Models\EducationDetail;
use Illuminate\Http\Request;

class EducationDetailController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $educationDetails = EducationDetail::with('candidate')->get();

        return $this->successResponse($educationDetails);
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

        $results = EducationDetail::create($data);

        return $this->successResponse($results, 'Education added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $educationDetail = EducationDetail::where('id')->get()->first();

        return $this->successResponse($educationDetail);
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

        $educationDetail = EducationDetail::findOrFail($id);

        $educationDetail->update($data);

        return $this->updateResponse('Education updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $educationDetail = EducationDetail::findOrFail($id);

        $educationDetail->delete();

        return $this->updateResponse('Education trashed');
    }
}
