<?php
namespace models;
use Medoo\Medoo;
class BaseDao  extends Medoo
{
    function __construct()
    {
        $database = [
          'database_type'   => 'mysql',
          'database_name'   => 'ttttest',
          'server'          => '192.168.2.234',
          'username'        => 'root',
          'password'        => '123456',
          'prefix'          =>'tt_',//表前缀
          'port'            =>'12345',
          'charset'         =>'utf8'
        ];
        parent::__construct($database);
    }
}