<?php
require('vendor/autoload.php');
require('class/catetree.php');
require('class/dir.php');

use NoahBuscher\Macaw\Macaw;



//显示管理界面
Macaw::get('/',"controllers\Home@index");
//分类管理
Macaw::get('/catelist',"controllers\Category@index");
Macaw::post('/category/order',"controllers\Category@order");
Macaw::get('/category/toadd',"controllers\Category@toadd");
Macaw::post('/category/doadd',"controllers\Category@doadd");
Macaw::get('/category/toupdate',"controllers\Category@toupdate");
Macaw::post('/category/doupdate',"controllers\Category@doupdate");
Macaw::get('/category/dodelete',"controllers\Category@dodelete");


//图书管理
Macaw::get('/booklist',"controllers\Book@index");
Macaw::get('/booklist/(:num)',"controllers\Book@index");

Macaw::get('/book/toadd',"controllers\Book@toadd");
Macaw::post('/book/doadd',"controllers\Book@doadd");
Macaw::get('/book/toupdate',"controllers\Book@toupdate");
Macaw::post('/book/doupdate',"controllers\Book@doupdate");
Macaw::get('/book/dodelete',"controllers\Book@dodelete");

Macaw::POST('/upload',"controllers\Uploads@uploads");


/*
Macaw::get('/', function() {
    echo 'Im a GET request!';
});

Macaw::post('/', function() {
  echo 'Im a POST request!';
});

Macaw::any('/', function() {
    echo 'I can be both a GET and a POST request!';
});
Macaw::get('/hello', function(){
    echo  'hello';
});


Macaw::get('/(:num)aa',function ($data){
    echo $data;
});

Macaw::get('index2',"controllers\Test@index");
Macaw::get('index3',"controllers\Test2@index");

Macaw::get('view', 'controllers\Test@index');
Macaw::get('get_user','controllers\Test@get_user');

Macaw::get('view/(:num)', 'Controllers\demo@view');



Macaw::error(function() {
    echo '404 :: Not Found';
});*/

Macaw::dispatch();
