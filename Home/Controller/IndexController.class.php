<?php

namespace Home\Controller;

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

        $this->smarty->assign(
            array('links' => $links,
                'categorys' => $categorys,
                'months' => $months,
            ));
        $this->smarty->display("./Index/index.html");
    }
}
