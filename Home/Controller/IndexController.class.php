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

        /**
         * 构造搜索条件
         */
        $where = "2>1"; //default value
        if (!empty($_REQUEST['category_id'])) {
            $where .= " AND article.category_id=" . $_REQUEST['category_id'];
        }
        if (!empty($_REQUEST['keyword'])) {
            $where .= " AND title LIKE '%" . $_REQUEST['keyword'] . "%'";
        }

        $pagesize = 5;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $startrow = ($page - 1) * $pagesize; //开始行号
        $records = ArticleModel::getInstance()->rowCount($where);
        $params = array('c' => CONTROLLER, 'a' => ACTION); //附加参数

        if (!empty($_REQUEST['category_id'])) {
            $params['category_id'] = $_REQUEST['category_id'];
        }
        if (!empty($_REQUEST['keyword'])) {
            $params['keyword'] = $_REQUEST['keyword'];
        }

        $pageObj = new Pager($records, $pagesize, $page, $params);
        $pageStr = $pageObj->showPage();

        $articles = ArticleModel::getInstance()->fetchAllWithJoin($where,$startrow, $pagesize);

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
