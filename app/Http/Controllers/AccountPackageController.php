<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTrait;
use App\Models\AccountPackage;
use Illuminate\Http\Request;

class AccountPackageController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = AccountPackage::get();

        return $this->successResponse($packages);
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

        $results = AccountPackage::create($data);

        return $this->successResponse($results, 'Package created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $package = AccountPackage::where('id', $id)->get()->first();

        return $this->successResponse($package);
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

        $package = AccountPackage::findOrFail($id);

        $package->update($data);

        return $this->updateResponse('Package updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $package = AccountPackage::findOrFail($id);

        $package->delete();

        return $this->updateResponse('Package deleted!');
    }
}
