<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTrait;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $applications = Application::with(['candidate', 'project'])->get();

        if (count($applications) < 1) {
            return $this->resultsNotFoundResponse('No applications found');
        }

        return $this->paginateResponse($applications);
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

        $results = Application::create($data);

        return $this->successResponse($results, 'You have successfully applied for a job');
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $application = Application::with(['candidate', 'project'])->where('id', $id)->get()->first();

        return $this->successResponse($application);
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

        $application = Application::findOrFail($id);

        $application->update($data);

        return $this->updateResponse('Application updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $application = Application::findOrFail($id);

        $application->delete();

        return $this->updateResponse('Application trashed successfully!');
    }
}
