<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


Route::get('/', function() {
    return response()->json([
        'status' => 200,
        'message' => 'WalletMicroService is up and running !'
    ]);
});

Route::get('healthcheck', function () {

    $mysqlConnected = true;

    try {
        DB::table('wallets')->count('user_id');
    }
    catch(\Exception $e) {
        $mysqlConnected = false;
    }

    return response()->json([
        'mysql' => $mysqlConnected,
        // 'redis' => 'OK'
    ]);

});


Route::group(['prefix' => 'v1/wallet', 'namespace' => 'App\Http\V1\\'], function () {
    Route::get('get-balance/{user_id}', 'WalletController@getUserBalance')
        ->where('id', '[0-9]+')
        ->name('api_get_balance');

    Route::post('add-money', 'WalletController@addMoney')
        ->name('api_add_money');
});