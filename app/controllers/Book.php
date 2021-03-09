<?php
namespace controllers;
use models\BaseDao;
use ttttest\CateTree as CT;
use ttttest\Dir as DIR;
use Intervention\Image\ImageManagerStatic  as Image;
use JasonGrimes\Paginator;

class Book extends BaseControllers
{
    
    function index($num=1)
    {
        $db = new BaseDao();
        $count = $db->count('book');
        $totalItems = $count;   //总个数
        $itemsPerPage = 3;  //每页显示个数
        $currentPage = $num; //当前页
        $urlPattern = '/booklist/(:num)';
        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
        $this->assign('paginator',$paginator);
    
        $start = ($currentPage-1)* $itemsPerPage;
        $list = $db->select('book','*',['LIMIT'=>[$start,$itemsPerPage]]);
        $this->assign('list', $list);
    
        $treelist = $db->select('category',['id','catename','pid','ord']);
        $ntree = CT::getList($treelist);
        foreach ($ntree as $key=>$val){
            $catelist[$key] = $val['catename'];
        }
        $this->assign('ntree',$ntree);
        $this->assign('catelist',$catelist);
    
        
       
        
        $this->display('/book/index');
    }
    
    
    /**
     * 添加图书的页面
     */
    function toadd()
    {
        $db = new BaseDao();
        $treelist = $db->select('category', ['id', 'catename', 'pid', 'ord']);
        $ntree = CT::getList($treelist);
        $this->assign('ntree', $ntree);
        
       
        $this->display('/book/toadd');
    }
    
    /**
     * 添加图书
     */
    function doadd()
    {
        $db = new BaseDao();
        unset($_POST['submit']);
        $filename = parent::_uploads() ? :'';
        $book = $_POST;
        $book['filename'] = $filename;
        $path = dirname(dirname(__DIR__));
        
//        echo $path."/uploads/".$filename;exit;
    
        $img = Image::make($path."/uploads/".$filename);
        $img ->resize(200,200);
        $img ->insert($path.'/public/watermark.png');
        
        $path2 = dirname($path.'/public/small/'.$filename);
        
        DIR::createdirlist($path2,0777);
        $img ->save($path.'/public/small/'.$filename);
        
        $data = $db->insert('book', $book);
        if ($data->rowCount() > 0) {
            $this->success('/booklist', '添加成功');
        } else {
            $this->success('/book/toadd', '添加失败');
        }
    }
    
    function toupdate()
    {
        $db = new BaseDao();
        $treelist = $db->select('category', ['id', 'catename', 'pid', 'ord']);
        $ntree = CT::getlist($treelist);
        //       获取一条要修改的记录
        $cate = $db->get(
          'category',
          ['id', 'catename', 'pid', 'ord'],
          ['id' => $_GET['id']]
        );
        $this->assign('cate', $cate);
        $this->assign('ntree', $ntree);
        $this->display('category/toupdate');
        
    }
    
    function doupdate()
    {
        $db = new BaseDao();
        unset($_POST['submit']);
        $id = $_POST['id'];
        unset($_POST['id']);
        //        父类不能修改到自己的子类下面
        $treelist = $db->select('category', ['id', 'catename', 'pid', 'ord']);
        $ntree = CT::getlist($treelist);
        $selftree = $ntree[$id];
        if (in_array($_POST['pid'], explode(',', $selftree['children']))) {
            $this->error('/catelist', '父类不能修改到自己的子类下面！');
        } else {
            $data = $db->update('category', $_POST, ['id' => $id]);
            
            if ($data->rowCount() > 0) {
                $this->success('/catelist', '修改成功');
            } else {
                $this->error('/catelist', '修改失败！');
            }
        }
    }
    
    function dodelete()
    {
        $db = new BaseDao();
        $treelist = $db->select('category', ['id', 'catename', 'pid', 'ord']);
        $ntree = CT::getlist($treelist);
        $selftree = $ntree[$_GET['id']];
        if ($selftree['children']) {
            $this->error('/catelist', '不能删除有子分类的分类！');
        } else {
            $data = $db->delete('category', ['id' => $_GET['id']]);
            if ($data->rowCount() > 0) {
                $this->success('/catelist', '删除成功');
            } else {
                $this->error('/catelist', '删除失败！');
            }
        }
    }
}
