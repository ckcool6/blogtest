<?php

namespace Home\Controller;

use Frame\Vendor\Pager;
use Home\Model\ArticleModel;
use Home\Model\CategoryModel;
use Home\Model\LinksModel;
use Frame\Libs\BaseController;
use Home\Model\IndexModel;

final class IndexController extends BaseController
{
    public function index()
    {
        /**
         * 获取友情links
         */
        $links = LinksModel::getInstance()->fetchAll();

        /**
         * 获取categorys
         */
        $categorys = \Admin\Model\CategoryModel::getInstance()->categoryList(CategoryModel::getInstance()->fetchAllWithJoin());

        /**
         * 获取按月份归档
         */
        $months = ArticleModel::getInstance()->fetchAllWithCount();

        /**
         * 获取文章并分页
         */
        $pagesize = 5;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $startrow = ($page - 1) * $pagesize; //开始行号
        $records = ArticleModel::getInstance()->rowCount();
        $params = array('c' => CONTROLLER, 'a' => ACTION); //附加参数

        $pageObj = new Pager($records, $pagesize, $page, $params);
        $pageStr = $pageObj->showPage();

        $articles = ArticleModel::getInstance()->fetchAllWithJoin($startrow, $pagesize);

        $this->smarty->assign(
            array('links' => $links,
                'categorys' => $categorys,
                'months' => $months,
                'articles' => $articles,
                'pageStr' => $pageStr,
            ));
        $this->smarty->display("./Index/index.html");
    }
}
