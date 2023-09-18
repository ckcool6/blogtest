<?php

namespace Home\Controller;

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

        $this->smarty->assign(
            array('links' => $links,
                'categorys' => $categorys,
            ));
        $this->smarty->display("./Index/index.html");
    }
}
