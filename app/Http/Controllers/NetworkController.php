<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTrait;
use App\Models\Network;
use Illuminate\Http\Request;

class NetworkController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $networks = Network::get();

        return $this->successResponse($networks);
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

        $results = Network::create($data);

        return $this->successResponse($results);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $network = Network::where('id', $id)->get()->first();

        return $this->successResponse($network);
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

        $network = Network::findOrFail($id);

        $network->update($data);

        return $this->updateResponse('Network updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $network = Network::findOrFail($id);

        $network->delete();

        return $this->updateResponse('Network trashed!');
    }

    public function member_network ($id)
    {
        $network = Network::with(['member'])->where('leader_id', $id)->get();
    }
}
