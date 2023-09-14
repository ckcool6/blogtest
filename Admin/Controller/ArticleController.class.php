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

        $categorys = CategoryModel::getInstance()->categoryList(CategoryModel::getInstance()->fetchAll("id ASC"));

        $this->smarty->assign("categorys", $categorys);
        $this->smarty->display("./Article/add.html");

    }

    public function insert()
    {
        $data['user_id'] = $_SESSION['uid'];
        $data['category_id'] = $_POST['category_id'];
        $data['title'] = $_POST['title'];
        $data['orderby'] = $_POST['orderby'];
        $data['top'] = isset($_POST['top']) ? 1 : 0;
        $data['content'] = $_POST['content'];
        $data['addate'] = time();

        if (ArticleModel::getInstance()->insert($data)) {
            $this->jump("文章添加成功！", "?c=Article");
        } else {
            $this->jump("文章添加失败！", "?c=Article");
        }
    }
}
