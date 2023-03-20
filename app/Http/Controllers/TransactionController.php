<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\QrDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('transaction.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $qr_code = $request->input('qr_code');
        Transaction::create([
            'qr_scanned' => $qr_code,
            'scanned_by' => 'ORDINARY',
            'created_at' =>  Carbon::now()->toDateTimeString()
        ]);

        $exists = $this->does_exist($qr_code);

        activity_log('LOGIN');
        return response()->json([
            'qr_code' => $qr_code,
            'exists' => $exists,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        $transactions = Transaction::join('qr_details', 'transactions.qr_scanned', '=', 'qr_details.qr_code')
            ->select('transactions.qr_scanned', 'transactions.created_at')
            ->paginate(10);

        return $transactions;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }

    private function does_exist($qr_scanned){
        return QrDetail::where('qr_code', $qr_scanned)->exists();
    }
}
