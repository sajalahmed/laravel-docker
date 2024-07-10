<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PayRequest;
use App\Http\Resources\PayResource;
use App\Models\Transation;
use App\Services\PaymentService;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    /**
     * return success or failed response.
     */
    public function index(Request $request): JsonResponse
    {
        $header = $request->header('X-Mock-Status'); 
        if(!$header){
            return response()->json([
                "status" => "Failed"
            ], Response::HTTP_FAILED_DEPENDENCY);
        }
        return response()->json([
            "status" => "Accepted"
        ], Response::HTTP_ACCEPTED);
    }
    /**
     * requesst params = [user_id, amount]
     */
    public function pay(PayRequest $request): JsonResponse
    {
        $amount = $request->amount;
        $userId = $request->user_id;
        $transation = app(PaymentService::class)->makePay($userId, $amount);

        if($transation){
            return response()->json([
                "status" => "Success",
                "data" => new PayResource($transation)
            ], Response::HTTP_CREATED);
        }
        return response()->json([
            'status' => "Failed"
        ], Response::HTTP_FAILED_DEPENDENCY);
    }

    /**
     * Route /:transation
     * Request params [status]
    */
    public function callback(Request $request, Transation $transation): JsonResponse
    {
        $request->validate([
            "status" => "required|numeric"
        ]);
        $status = $request->status;
        app(PaymentService::class)->updatePay($transation, $status);

        return response()->json([
            "status" => "success"
        ], Response::HTTP_OK);
    }
}
