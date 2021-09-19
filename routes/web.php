<?php

use Illuminate\Support\Facades\Route;


Route::group(['domain' => '127.0.0.1'], function(){
    Route::get('/', function(){ return 'this is the main domain page'; });
});

Route::group(['domain' => 'sup.127.0.0.1'], function(){
    Route::get('/', function(){ return 'this is sup-domain page'; });
});

Route::group(['domain' => '{all}'], function(){
   
    Route::get('/', function(){ return 'this is domain route to your back-end ';})->where('all', '.*')->middleware('domain.verify');

});
