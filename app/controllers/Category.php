<?php
namespace controllers;
use models\BaseDao;

use ttttest\CateTree as CT;

class Category extends BaseControllers
{
    function index()
    {
        $db = new BaseDao();
        $treelist = $db->select('category',['id','catename','pid','ord']);
        $ntree = CT::getList($treelist);
        $this->assign('ntree',$ntree);
        $this->display('/category/index');
    }
    
    /**
     * 修改分类
     */
    function  order ()
    {
        $db = new BaseDao();
        if(!empty($_POST['id'])){
            foreach ( $_POST['id'] as $key=>$val){
                $db->update('category',['ord'=>$val],['id'=>$key]);
            }
        }
        $this->success('/catelist','排序修改成功');
    }
    
    function toadd()
    {
        $db = new BaseDao();
        $treelist = $db->select('category',['id','catename','pid','ord']);
        $ntree = CT::getList($treelist);
        $this->assign('ntree',$ntree);
        $this->display('/category/toadd');
    }
    function doadd()
    {
        $db = new BaseDao();
        unset($_POST['submit']);
        $data = $db->insert('category',$_POST);
        if($data->rowCount()>0){
            $this->success('/catelist','添加成功');
        }
        $this->success('/category/toadd','添加失败');
    }
    
    function toupdate()
    {
       $db  = new BaseDao();
       $treelist = $db->select('category',['id','catename','pid','ord']);
       $ntree = CT::getlist($treelist);
//       获取一条要修改的记录
       $cate = $db->get('category',['id','catename','pid','ord'],['id'=>$_GET['id']]);
       $this->assign('cate',$cate);
       $this->assign('ntree',$ntree);
       $this->display('category/toupdate');
        
    }
    
    function doupdate()
    {
        $db  = new BaseDao();
        unset($_POST['submit']);
        $id = $_POST['id'];
        unset($_POST['id']);
//        父类不能修改到自己的子类下面
        $treelist = $db->select('category',['id','catename','pid','ord']);
        $ntree = CT::getlist($treelist);
        $selftree = $ntree[$id];
        if (in_array($_POST['pid'],explode(',',$selftree['children']))) {
            $this->error('/catelist','父类不能修改到自己的子类下面！');
        }else{
            $data = $db->update('category',$_POST,['id'=>$id]);
    
            if($data->rowCount()>0){
                $this->success('/catelist','修改成功');
            }else{
                $this->error('/catelist','修改失败！');
            }
        }
    }
    
    function dodelete()
    {
        $db = new BaseDao();
        $treelist = $db->select('category',['id','catename','pid','ord']);
        $ntree = CT::getlist($treelist);
        $selftree = $ntree[$_GET['id']];
        if ($selftree['children']){
            $this->error('/catelist','不能删除有子分类的分类！');
        }else{
            $data = $db->delete('category',['id'=>$_GET['id']]);
            if($data->rowCount()>0){
                $this->success('/catelist','删除成功');
            }else{
                $this->error('/catelist','删除失败！');
            }
        }
        
        
    
        
        
    }

    
    
    
    
}