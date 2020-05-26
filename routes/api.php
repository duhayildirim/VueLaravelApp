<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\User;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('users','api\UserController');

//Route::get('/users', 'Api\UserController@index');

//Route::get('/users' , function () {
//////   return [
//////       ['Id'=> 1 , 'Name'=> 'Cem' , 'Email'=> 'asdasdasd@asdasd.asd'],
//////       ['Id'=> 2 , 'Name'=> 'Duha' , 'Email'=> 'qwewqqwee@qqwewe.qwe'],
//////       ['Id'=> 3 , 'Name'=> 'Selin' , 'Email'=> 'zxczxczxc@zxcxzc.zxc']
//////       ];
////   if(rand(1,10)<3) {
////       abort(500,'bir hata oluştu');
////   } // fake bir hata oluşturdum}
//////    return factory('App\User' , 10)->make();
//////    return App\User::all();
////
////    return response()->json(['users' => App\User::all()],200);
//
//});
