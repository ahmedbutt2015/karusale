<?php
use Illuminate\Support\Facades\Auth;

    Route::get('/', function () {
        return view('index');
    });

    Route::get('/user/logout', function () {
        Auth::logout();
        return redirect('/');
    });

    Route::group(['middleware' => 'guest'],function() {
        
        Route::any('/register', 'AuthController@register');
        Route::any('/login', 'AuthController@login');
        Route::get('/user/verify/{id}', 'AuthController@verifyUser');

        Route::group(['middleware' => 'admin_auth'],function() {
            Route::get('/admin', 'AdminController@index');
            Route::delete('/admin/user/delete/{id}', 'UserController@delete');
            Route::put('/admin/user/edit/{id}', 'UserController@edit');
            Route::post('/admin/user/add', 'UserController@add');
            Route::get('/admin/user/logout',function(){
                session()->flush();
                return redirect('/admin/login');
            });
        });

        Route::group(['middleware' => 'admin_guest'],function() {
            Route::any('/admin/login', 'AdminController@login');
        });
    });
