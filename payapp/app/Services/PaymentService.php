<?php

namespace App\Services;

use App\Models\Transation;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    public function makePay($userId, $amount): Transation |null
    {
        $transation = null;
        DB::beginTransaction();
        try{
            $transation = Transation::create([
                'user_id' => $userId,
                'amount' => $amount
            ]);
            DB::commit();
        } catch(Exception $e){
            Log::error($e->getMessage());
            DB::rollback();
        }
        return $transation;
    }

    public function updatePay($transation, $status): void
    {
        $transation->status = $status;
        $transation->save();
    }
}
