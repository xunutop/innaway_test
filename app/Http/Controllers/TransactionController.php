<?php

namespace App\Http\Controllers;

use App\Events\TransactionCreated;
use App\Events\TransactionDeleted;
use App\Events\TransactionUpdated;
use App\Helpers\Helper;
use App\Transaction;
use Illuminate\Http\Request;
use App\Rules\SellQuantity;
use App\Rules\TransactionCode;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::all();
        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('transactions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', new TransactionCode($request->get('type'))],
            'type' => 'required|in:' . Helper::transactionTypeStr(),
            'quantity' => ['required', 'numeric', 'min:1', new SellQuantity($request->get('type'), $request->get('code'))],
            'date' => 'required|date'
        ]);

        $available =  $request->get('type') == config('constants.transaction.type.buy') ? $request->get('quantity') : 0;
        $transaction = new  Transaction([
            'code' => $request->get('code'),
            'type' => $request->get('type'),
            'quantity' => $request->get('quantity'),
            'available' => $available,
            'date' => $request->get('date'),
        ]);

        $transaction->save();

        event(new TransactionCreated($transaction));

        return redirect('/transactions')->with('success', 'Saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $transaction = Transaction::find($id);
        return view('transactions.edit', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required',
            'type' => 'required|in:' . Helper::transactionTypeStr(),
            'quantity' => 'required|numeric|min:1',
            'date' => 'required|date'
        ]);

        $available =  $request->get('type') == config('constants.transaction.type.buy') ? $request->get('quantity') : 0;
        $transaction = Transaction::find($id);
        $transaction->code = $request->get('code');
        $transaction->type = $request->get('type');
        $transaction->quantity = $request->get('quantity');
        $transaction->available = $available;
        $transaction->date= $request->get('date');
        $transaction->save();

        event(new TransactionUpdated($transaction));

        return redirect('/transactions')->with('success', 'Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = Transaction::find($id);
        $transaction->delete();

        event(new TransactionDeleted($transaction));

        return redirect('/transactions')->with('success', 'Deleted!');
    }
}

