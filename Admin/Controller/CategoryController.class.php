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
}