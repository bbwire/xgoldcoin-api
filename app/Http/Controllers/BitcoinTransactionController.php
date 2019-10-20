<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTrait;
use App\Models\BitcoinTransaction;
use Illuminate\Http\Request;

class BitcoinTransactionController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = BitcoinTransaction::get();

        return $this->successResponse($transactions);
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

        $results = BitcoinTransaction::create($data);

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
        $transaction = BitcoinTransaction::where('id', $id)->get()->first();

        return $this->successResponse($transaction);
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

        $transaction = BitcoinTransaction::findOrFail($id);

        $transaction->update($data);

        return $this->updateResponse('Transaction updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = BitcoinTransaction::findOrFail($id);

        $transaction->delete();

        return $this->updateResponse('Transaction deleted!');
    }
}
