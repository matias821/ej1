<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//ruta para pruebas
Route::post('/register',                                          'App\Http\Controllers\Api\AuthController@register');

Route::group(['middleware'=>'auth:api'], function(){

    Route::get('/role_profesional',                               'App\Http\Controllers\Api\AuthController@roleProfesional');
    Route::get('/role_visita',                                    'App\Http\Controllers\Api\AuthController@roleVisita');
    Route::get('/role_get',                                       'App\Http\Controllers\Api\AuthController@roleGet');

    Route::get('info',                                            'App\Http\Controllers\Api\AuthController@info');
    Route::post('/testOauth',                                     'Api\AuthController@testOauth');

    Route::get('/user_basica',                                    'App\Http\Controllers\Api\UserDataController@userInfo');
    Route::get('/user_avanzada',                                  'App\Http\Controllers\Api\UserDataController@userAvanzada');
    Route::get('/user_foto',                                      'App\Http\Controllers\Api\UserDataController@userFoto');
    Route::get('/user_actividad',                                 'App\Http\Controllers\Api\UserDataController@userActividad');
    Route::post('/user_actividad',                                'App\Http\Controllers\Api\UserDataController@userActividadAct');
    Route::post('/user_name',                                     'App\Http\Controllers\Api\UserDataController@userNameAct');
    Route::post('/user_foto',                                     'App\Http\Controllers\Api\UserDataController@userFotoAct');

    Route::get('/profesionales_listar',                           'App\Http\Controllers\Api\UserDataController@profesionalesListar');
    Route::apiResource('/cotizaciones',                           'App\Http\Controllers\Api\CotiController');
    Route::apiResource('/comentarios',                            'App\Http\Controllers\Api\ComentController');
});


