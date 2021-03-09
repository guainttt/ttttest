<?php
namespace controllers;
use Illuminate\Translation\ArrayLoader;
//use models\Home;

class Home extends BaseControllers
{
   
    function index()
    {
      
        $this->display('index');
    }
    
    
    
}