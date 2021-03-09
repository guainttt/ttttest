<?php
namespace controllers;
use Illuminate\Translation\ArrayLoader;
use models\User;

class Test extends BaseControllers
{
    function get_user()
    {
        $user = new User();
        $user->insert('user', [
          'name' => 'foo',
          'date_time' => date("Y-m-d H:i:s")
        ]);
        $data = $user->select("user","*");
        
        dd($data);
    }
    function index()
    {
        echo phpinfo();
        exit;
//        $this->assign('one','abc');
        $one = 'abc';
        $two = 'def';
        $three = array('a'=>'a','b'=>'b');
        $data = compact('one','two','three');
        $this->assign('data',$data);
        $list = [
          ['href'=>'www.baidu.com','name'=>'百度'],
          ['href'=>'www.qq.com','name'=>'qq']
        ];
        $this->assign('list',$list);
        $this->assign('title','我的视图');
//        dd($this->data);
        $this->display('index');
    }
    
    
    
}