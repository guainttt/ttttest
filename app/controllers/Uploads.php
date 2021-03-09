<?php
namespace controllers;
use models\BaseDao;

use Slince\Upload\UploadHandlerBuilder ;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Uploads
{
    function uploads()
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
            } else {
//                echo $uploadedFile->getClientOriginalName() . ' upload error: ' . $file->getException()->getMessage();
            }
//            echo PHP_EOL;
        }
        
        
       
    

        
    }
    
    
    

}
