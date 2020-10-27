<?php

Route::get('/reconstruct', ['uses' => 'IndexController@reconstruction', 'as' => 'site.recon']);


Auth::routes();

Route::get('/', ['uses' => 'IndexController@index', 'as' => 'site.index']);

Route::get('/object/{object}', ['uses' => 'ObjectController@index', 'as' => 'site.object']);
Route::get('/catalog/{order?}', ['uses' => 'CatalogController@index', 'as' => 'site.catalog']);
Route::get('/post/{post}', ['uses' => 'PostController@show', 'as' => 'site.post']);
Route::post('/sendmail/', ['uses' => 'MailController@sendRequest', 'as' => 'site.send']);
Route::post('/sendmailcall/', ['uses' => 'MailController@sendCall', 'as' => 'site.sendCall']);
Route::post('/sendtelegram/', ['uses' => 'TelegramController@sendMessage', 'as' => 'site.sendTelegram']);
Route::get('/curlAvitoK/', ['uses' => 'IndexController@curlAvitoK', 'as' => 'object.curlParseK']);
Route::get('/curlAvitoKA/', ['uses' => 'IndexController@curlAvitoKA', 'as' => 'object.curlParseKA']);
Route::get('/curlAvitoH/', ['uses' => 'IndexController@curlAvitoH', 'as' => 'object.curlParseH']);
Route::get('/curlAvitoHA/', ['uses' => 'IndexController@curlAvitoHA', 'as' => 'object.curlParseHA']);
Route::get('/curlAvitoC/', ['uses' => 'IndexController@curlAvitoC', 'as' => 'object.curlParseC']);
Route::get('/curlAvitoCA/', ['uses' => 'IndexController@curlAvitoCA', 'as' => 'object.curlParseCA']);
Route::get('/calls', ['uses' => 'Admin\CallController@index', 'as' => 'call.parse']);
Route::get('/checkactivate', ['uses' => 'Admin\ObjectController@checkCompleted', 'as' => 'object.check.completed']);
Route::get('/districts', ['uses' => 'Admin\ObjectController@CreateDistricts', 'as' => 'object.createDistricts']);
Route::get('/js/{file}', function($file = null)
{
    $path = storage_path().'/app/public/new_life/js/'.$file.".js";
    if (file_exists($path)) {
        return response()->download($path)->deleteFileAfterSend(true);
    }
});
Route::get('/xml/{file}.xml', function($file = null)
{
    $path = storage_path().'/app/public/new_life/xml/' . $file . '.xml';
    if (file_exists($path)) {
        return response()->file($path);
    }
});
//admin
Route::group(['prefix' => 'admin','middleware' => ['auth']],function() {
//
    Route::get('/api/objects', ['uses' => 'Admin\ObjectController@getJson', 'as' => 'api.object']);

    Route::get('/call/{data}/{url}', ['uses' => 'Admin\CallController@getCall', 'as' => 'call.get']);
    Route::get('/calls/', ['uses' => 'Admin\CallController@callsList', 'as' => 'call.list']);
    Route::get('/object/create/{category}/{deal}/{type}', ['uses' => 'Admin\ObjectController@create', 'as' => 'object.create']);
    Route::get('/avito/{order?}', ['uses' => 'Admin\IndexController@avito', 'as' => 'object.avito']);
    Route::resource('/object', 'Admin\ObjectController',['except' => ['index', 'create']]);
    Route::resource('/user', 'Admin\UserController');
    Route::resource('/post', 'Admin\PostController');
    Route::resource('/news', 'Admin\NewsController');
    Route::resource('/ticket', 'Admin\TicketController');
    Route::resource('/comfort', 'Admin\ComfortController',['only' => ['index', 'store', 'destroy']]);
    Route::get('/transfer/{aobject}', ['uses' => 'Admin\AobjectController@transfer', 'as' => 'aobject.transfer']);
    Route::get('/favorites/', ['uses' => 'Admin\FavoriteController@index', 'as' => 'admin.favorites']);
    Route::post('/transfer', ['uses' => 'Admin\AobjectController@store', 'as' => 'aobject.store']);
    Route::group(['prefix' => 'settings'],function() {
       Route::get('/edit', ['uses' => 'Admin\SettingController@edit', "as" => 'settings.edit']);
       Route::put('/', ['uses' => 'Admin\SettingController@update', "as" => 'settings.update']);
    });
    Route::group(['prefix' => 'action'],function() {
        Route::put('/favorite/{object}',['uses'=>'Admin\FavoriteController@Favorite','as'=>'object.favorite']);
        Route::put('/afavorite/{aobject}',['uses'=>'Admin\FavoriteController@AFavorite','as'=>'aobject.favorite']);
        Route::put('/prework/{object}',['uses'=>'Admin\ObjectController@InPrework','as'=>'object.prework']);
        Route::put('/out/{object}',['uses'=>'Admin\ObjectController@Out','as'=>'object.out']);
        Route::delete('/unout/{object}',['uses'=>'Admin\ObjectController@UnOut','as'=>'object.unout']);
        Route::put('/unwork/{object}',['uses'=>'Admin\ObjectController@Unwork','as'=>'object.unwork']);
        Route::put('/accessprework/{object}',['uses'=>'Admin\ObjectController@AccessPrework','as'=>'object.accessPreWork']);
        Route::put('/cancelprework/{object}',['uses'=>'Admin\ObjectController@CancelPrework','as'=>'object.cancelPreWork']);
        Route::put('/activate/{object}',['uses'=>'Admin\ObjectController@Activate','as'=>'object.activate']);
        Route::put('/restore/{object}',['uses'=>'Admin\ObjectController@Restore','as'=>'object.restore']);
        Route::delete('/delete/{aobject}',['uses'=>'Admin\AobjectController@destroy','as'=>'aobject.delete']);
        Route::delete('/softdelete/{object}',['uses'=>'Admin\ObjectController@softDelete','as'=>'object.softDelete']);
        Route::get('/export/{user?}',['uses'=>'Admin\ObjectController@export','as'=>'object.export']);
        Route::get('/phone/{object}',['uses'=>'Admin\ObjectController@ShowPhone','as'=>'object.phone']);
        Route::post('/mass',['uses'=>'Admin\ObjectController@MassAction','as'=>'object.mass.action']);
    });
    Route::group(['prefix' => 'image'],function() {
        Route::post('/delete',['uses'=>'Admin\Storage@objDeleteImage','as'=>'adminObjDelImg']);
        Route::post('/post',['uses'=>'Admin\Storage@UploadImage','as'=>'adminUplImg']);
        Route::post('/upload',['uses'=>'Admin\Storage@objUploadImage','as'=>'adminObjUplImg']);
        Route::get('/get',['uses'=>'Admin\Storage@objGetImage','as'=>'adminObjGetImg']);
    });
    //INDEX
    Route::get('/{type?}/{order?}',['uses' => 'Admin\IndexController@index','as' => 'adminIndex']);
});


Route::get('/home', 'HomeController@index')->name('home');
