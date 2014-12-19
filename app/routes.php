<?php

get('test/{id?}', 'HomeController@index')->where('id', '[0-9]+');
get('shop/{name}/{other}/{id}', 'HomeController@index');
get('shop/{name?}', 'HomeController@index');