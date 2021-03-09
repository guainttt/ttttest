<?php
namespace controllers;
use Slince\Upload\UploadHandlerBuilder ;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class BaseControllers
{
    protected $twig;
    protected $data=array();
    
    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__).'/views');
        $this->twig = new \Twig\Environment($loader, [
          //是否开启模板缓存
         // 'cache' => '/path/to/compilation_cache',
           'debug' => true ,    //debug 布尔值（默认为 false）：如果设置为 true，则可以在模板中使用__toString() 方法进行调试。同时可以使用 dump() 函数；
           /*
           'charset'=>'utf-8',  //charset 字符串（默认为 utf-8）：设置模板的字符集；
           'cache'=>false,      //cache 字符串或 false（默认为 false）：设置保存已编译模板的绝对路径；
           'auto_reload'=>true, //auto_reload 布尔值：如果设置为 ture，当模板源文件有改动时会自动重新加载进行编译，开发时非常有用。auto_reload的默认值基于debug的设置；
           'strict_variables'=>true,//strict_variables 布尔值（默认为 false）：当变量或属性值不存在时，返回null。如果设置为 true，Twig将抛出异常；
           'autoescape'=>true  //autoescape 字符串或布尔值（默认为 true）：设置是否启用默认转义或设置转义规则（html, js, css, url, html_attr等）；
        */
        ]);
    
       
        
    }
   
    public function display($template)
    {
        echo $this->twig->render($template.'.html', $this->data);
    }
    public  function assign($key,$value=null)
    {
        if(is_array($value)){
          $this->data[$key] = array_merge($value);
        }else{
            $this->data[$key] = $value;
        }
    }
    
    function success($url,$mess)
    {
        echo "<script>";
        echo "alert('{$mess}');";
        echo "location.href='{$url}';";
        echo "</script>";
    }
    
    function error($url,$mess)
    {
        echo "<script>";
        echo "alert('{$mess}');";
        echo "location.href='{$url}';";
        echo "</script>";
    }
    
    protected function _uploads()
    {
        $path = dirname(dirname(__DIR__))."/uploads";
        $builder = new UploadHandlerBuilder(); //create a builder.
        $handler = $builder
          
          ->overwrite(true) // open overwrite mode.
          
          //Custom namer
          ->naming(function (UploadedFile $file) {
              return date('Y/md') . '/' . uniqid() . '.' . $file->getClientOriginalExtension();
          })
          
          //add constraints
          ->sizeBetween('1k', '20m')
          ->allowExtensions(['jpg', 'txt','png','gif','JPG'])
          ->allowMimeTypes(['image/*', 'text/plain'])
          ->saveTo($path) //save to local
          ->getHandler();
        
        $files = $handler->handle();
        
        //        dd($files);
        foreach ($files as $file) {
            $uploadedFile = $file
              ->getUploadedFile();
            if ($file->isUploaded()) {
                //                echo $uploadedFile->getClientOriginalName() . ' upload ok, path:' . $file->getDetails()->getPathname();
                //1.JPG upload ok, path:/var/www/html/ttttest/uploads/2021/0305/604294cebb954.JPG
                return $file->getName();
            } else {
                //                echo $uploadedFile->getClientOriginalName() . ' upload error: ' . $file->getException()->getMessage();
            }   return false;
            //            echo PHP_EOL;
        }
        
    }
    
}