<?php
namespace controllers;

class Demo {
    
    public function index()
    {
        echo 'home';
    }
    
    public function page()
    {
        echo 'page';
    }
    
    public function view($id)
    {
        echo $id;
    }
    
}