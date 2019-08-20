<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTrait;
use App\Models\ShortList;
use Illuminate\Http\Request;

class ShortListController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shortList = ShortList::with(['client', 'project'])->get();

        return $this->successResponse($shortList);
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

        $results = ShortList::create($data);

        return $this->successResponse($results, 'Short listed!');
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shortList = ShortList::with(['client', 'project'])->get()->first();

        return $this->successResponse($shortList);
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

        $shortList = ShortList::findOrFail($id);

        $shortList->update($data);

        return $this->updateResponse('Short list updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shortList = ShortList::findOrFail($id);

        $shortList->delete();

        return $this->updateResponse('Short list trashed!');
    }
}
