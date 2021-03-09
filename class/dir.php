<?php
namespace ttttest;
class  Dir
{
    /*$path="/a/x/cc/cd"; //要创建的目录
    $mode=0755; //创建目录的模式，即权限.
    createdirlist($path,$mode);//测试*/
    public static function createdirlist($path,$mode)
    {
        if (is_dir($path)){  //判断目录存在否，存在不创建
            echo "目录'" . $path . "'已经存在";//已经存在则输入路径
        }else{ //不存在则创建目录
            $re=mkdir($path,$mode,true); //第三个参数为true即可以创建多极目录
            if ($re){
                return true;//目录创建成功
            }
            
        }
        return false;
    }

}
?>