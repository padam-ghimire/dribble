<?php

// For Authenticated Users


Route::group(['middleware'=>['auth:api']],function(){



});



// For guest users
Route::group(['middleware'=>['guest:api']],function(){


    Route::post('/register','Auth\RegisterController@register');
    Route::get('/verification/verify','Auth\VerificationController@verify')->name('verification.verify');
    Route::get('/verification/resend','Auth\VerificationController@resend');

    
});