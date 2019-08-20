<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTrait;
use App\Models\CompanyContact;
use Illuminate\Http\Request;

class CompanyContactController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companyContacts = CompanyContact::with('client')->get();

        return $this->successResponse($companyContacts);
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

        $results = CompanyContact::create($data);

        return $this->successResponse($results, 'Company contacts added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CompanyContact  $companyContact
     * @return \Illuminate\Http\Response
     */
    public function show(CompanyContact $companyContact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CompanyContact  $companyContact
     * @return \Illuminate\Http\Response
     */
    public function edit(CompanyContact $companyContact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CompanyContact  $companyContact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CompanyContact $companyContact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CompanyContact  $companyContact
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompanyContact $companyContact)
    {
        //
    }
}
