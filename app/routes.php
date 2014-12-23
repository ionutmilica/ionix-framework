<?php

get('test/{id?}', 'HomeController@c')->where('id', '[0-9]+');
get('shop/{name}/{other}/{id}', 'HomeController@a');
get('shop/{name?}', 'HomeController@b');
get('/', 'HomeController@index');