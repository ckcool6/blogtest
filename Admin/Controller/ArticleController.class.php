<?php

namespace Admin\Controller;

use Admin\Model\ArticleModel;
use Admin\Model\CategoryModel;
use Frame\Libs\BaseController;

class ArticleController extends BaseController
{
    public function index()
    {
        $categorys = CategoryModel::getInstance()->categoryList(CategoryModel::getInstance()->fetchAll("id ASC"));
        $articles = ArticleModel::getInstance()->fetchAllWithJoin();

        $this->smarty->assign(array(
            'categorys' => $categorys,
            'articles' => $articles,
        ));

        $this->smarty->display("./Article/index.html");

    }

    public function add()
    {
        //todo
    }

    public function insert()
    {
        //todo
    }
}
