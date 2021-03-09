<?php
namespace controllers;
class Test2  extends BaseControllers
{
    function index()
    {
        echo "this is test2  index";
        $a = 'sjs';
        dd('ttt',$a);
    }
    function hello()
    {
        echo "this is hello";
    }
}