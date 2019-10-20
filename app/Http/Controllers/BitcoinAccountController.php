<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTrait;
use App\Models\BitcoinAccount;
use Illuminate\Http\Request;

class BitcoinAccountController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = BitcoinAccount::get();

        return $this->successResponse($accounts);
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

        $results = BitcoinAccount::create($data);

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
        $account = BitcoinAccount::where('id', $id)->get()->first();

        return $this->successResponse($account);
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

        $account = BitcoinAccount::findOrFail($id);

        $account->update($data);

        return $this->updateResponse('Account updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $account = BitcoinAccount::findOrFail($id);

        $account->delete();

        return $this->updateResponse('Account deleted!');
    }
}
