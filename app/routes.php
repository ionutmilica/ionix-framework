<?php

$app['router']->pattern('name', '[0-9]+');
$app['router']->get('test/{id?}', 'HomeController@index')->where('id', '[0-9]+');
$app['router']->get('shop/{name}/{other}/{id}', 'HomeController@index');
$app['router']->get('shop/{name?}', 'HomeController@index');