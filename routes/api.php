<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;


Route::post('login', [LoginController::class, 'login']);
Route::post('register', [RegisterController::class, 'register']);

Route::middleware('jwt.verify')->group(function () {
    
    Route::prefix('user')->group(function (){
            
    Route::get('profile', [UserController::class, 'getUserProfile']);
  
    Route::get('all', [UserController::class, 'getAllUsers']);

 
    Route::prefix('wallet')->group(function (){

    Route::get('/all', [WalletController::class, 'getAllWallets']);
    Route::get('/details/{id}', [WalletController::class, 'getWalletDetails']);
    Route::post('/send-money', [WalletController::class, 'sendMoney']);
    
    Route::post('/create-type', [WalletController::class, 'createWalletType']);
    Route::post('/create', [WalletController::class, 'createWallet']);
    Route::post('/fund', [WalletController::class, 'fundWallet']);

    });
            
        });
    
});