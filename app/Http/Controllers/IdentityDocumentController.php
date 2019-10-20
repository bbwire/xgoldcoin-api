<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTrait;
use App\Models\IdentityDocument;
use Illuminate\Http\Request;

class IdentityDocumentController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents = IdentityDocument::get();

        return $this->successResponse($documents);
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

        $user = Member::where('id', $data['member_id'])->get()->first();

        $results = IdentityDocument::create($data);

        return $this->successResponse($results, 'Document upload successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $document = IdentityDocument::where('id', $id)->get()->first();

        return $this->successResponse($document);
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

        $document = IdentityDocument::findOrFail($id);

        $document->update($data);

        return $this->updateResponse('Document updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $document = IdentityDocument::findOrFail($id);

        $document->delete();

        return $this->updateResponse('Document deleted!');
    }
}
