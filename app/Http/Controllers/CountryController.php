<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTrait;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = Country::get();

        if (count($countries) < 1) {
            return $this->resultsNotFoundResponse('No countries found!');
        }

        return $this->successResponse($countries);
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

        $results = Country::create($data);

        return $this->successResponse($results, 'Country has been created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $country = Country::where('id', $id)->get()->first();

        if (!$country) {
            return $this->notFoundResponse();
        }

        return $this->successResponse($country);
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
        $country = Country::findOrFail($id);

        $data = $request->all();

        $country->update($data);

        return $this->updateResponse('Country updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Country::findOrFail($id);

        $role->delete();

        return $this->updateResponse('Country trashed successfully!');
    }
}
