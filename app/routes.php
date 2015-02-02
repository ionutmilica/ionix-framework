<?php

group(function() {
    get('test/{id?}', 'App\Controllers\HomeController@c')->where('id', '[0-9]+');
    get('shop/{name}/{other}/{id}', 'App\Controllers\HomeController@a');
    get('shop/{name?}', 'App\Controllers\HomeController@b');
    get('/', 'App\Controllers\HomeController@index');
});

group('test', function () {
    group('bla', function () {
        get('/bla', function () {
            echo 'Bla !';
        });
        get('/tra', function ()
        {
            echo 'Bla !';
        });
    });
});
