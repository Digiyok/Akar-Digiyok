<?php

namespace App\Http\Services\Keuangan;

use App\Models\Pembayaran\ExchangeTransaction;
use App\Models\Pembayaran\ExchangeTransactionTarget;
use App\Models\Pembayaran\SppTransaction;

class ExchangeTransactionService {

    public function create($request)
    {
        $spp_trx = SppTransaction::find($request->id);
        $exchange = ExchangeTransaction::create([
            'transaction_id' => $request->id,
            'origin' => 2,
            'nominal' => $spp_trx->nominal,
            'refund' => $request->refund,
        ]);
        ExchangeTransactionTarget::create([
            'exchange_transaction_id' => $exchange->id,
            'student_id' => $spp_trx->student_id,
            'nominal' => $request->nominal_siswa,
            'transaction_type' => $request->jenis_pembayaran,
        ]);

        if($request->split == 1){
            ExchangeTransactionTarget::create([
                'exchange_transaction_id' => $exchange->id,
                'student_id' => $request->siswa_split,
                'nominal' => $request->nominal_split,
                'transaction_type' => $request->jenis_pembayaran_split,
            ]);
        }
    }

}