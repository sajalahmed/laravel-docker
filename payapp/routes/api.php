<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PaymentController;
use App\Http\Middleware\CacheControl;

Route::group(['prefix'=>'payment','as'=>'payment.'], function(){
  
    Route::get('/', [PaymentController::class, 'index']);
    Route::post('/store', [PaymentController::class, 'pay']);
    Route::post('/callback/{transation}', [PaymentController::class, 'callback'])->middleware(CacheControl::class);
});