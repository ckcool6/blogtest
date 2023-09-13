<?php

namespace Admin\Controller;

use Admin\Model\CategoryModel;
use Frame\Libs\BaseController;

class CategoryController extends BaseController
{
    public function index()
    {
        $categorys = CategoryModel::getInstance()->fetchAll("id ASC");

        $categorys = CategoryModel::getInstance()->categoryList($categorys);

        $this->smarty->assign("categorys", $categorys);
        $this->smarty->display("./Category/index.html");
    }

    public function add()
    {
        $categorys = CategoryModel::getInstance()->categoryList(CategoryModel::getInstance()->fetchAll("id ASC"));

        $this->smarty->assign("categorys", $categorys);
        $this->smarty->display("./Category/add.html");

    }

    public function insert()
    {
        $date['classname'] = $_POST['classname'];
        $date['orderby'] = $_POST['orderby'];
        $date['pid'] = $_POST['pid'];

        if (CategoryModel::getInstance()->insert($date)) {
            $this->jump("分类添加成功", "?c=Category");
        } else {
            $this->jump("分类添加失败", "?c=Category");
        }

    }

    public function delete()
    {
        //权限验证
        $this->denyAccess();
        //获取地址栏传递的id
        $id = $_GET['id'];

        if (CategoryModel::getInstance()->delete($id)) {
            $this->jump("id={$id}的记录删除成功", "?c=Category");
        } else {
            $this->jump("id={$id}的记录删除失败", "?c=Category");
        }
    }

}