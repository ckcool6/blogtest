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

    /**
     * 文章列表页
     * @return void
     */
    public function showList()
    {
        //(1)获取友情链接数据
        $links = LinksModel::getInstance()->fetchAll();

        //(2)获取无限级分类数据
        $categorys = CategoryModel::getInstance()->categoryList(
            CategoryModel::getInstance()->fetchAllWithJoin()
        );

        //(3)获取文章按月份归档数据
        $months = ArticleModel::getInstance()->fetchAllWithCount();

        //(4)构建搜索的条件
        $where = "2>1";
        if(!empty($_GET['category_id'])) $where .= " AND category_id=".$_GET['category_id'];
        if(!empty($_REQUEST['keyword'])) $where .= " AND title LIKE '%".$_REQUEST['keyword']."%'";

        //(5)构建分页参数
        $pagesize		= 30;
        $page 			= isset($_GET['page']) ? $_GET['page'] : 1;
        $startrow		= ($page-1)*$pagesize;
        $records 		= ArticleModel::getInstance()->rowCount($where);
        $params			= array('c'=>CONTROLLER,'a'=>ACTION);
        if(!empty($_GET['category_id'])) $params['category_id'] = $_GET['category_id'];
        if(!empty($_REQUEST['keyword'])) $params['keyword'] = $_REQUEST['keyword'];

        //(6)获取分页字符串数据
        $pageObj = new \Frame\Vendor\Pager($records,$pagesize,$page,$params);
        $pageStr = $pageObj->showPage();

        //(7)获取文章连表查询的分页数据
        $articles = ArticleModel::getInstance()->fetchAllWithJoin($where,$startrow,$pagesize);

        //(8)向视图赋值，并显示视图
        $this->smarty->assign(array(
            'links'		=> $links,
            'categorys'	=> $categorys,
            'months'	=> $months,
            'articles'	=> $articles,
            'pageStr'	=> $pageStr,
        ));
        $this->smarty->display("./Index/list.html");
    }

    /**
     * 文章内容页
     * @return void
     */
    public function content()
    {
        $id = $_GET['id'];
        //(1)更新文章阅读数
        ArticleModel::getInstance()->updateRead($id);

        //(2)根据ID获取连表查询的文章数据
        $article = ArticleModel::getInstance()->fetchOneWithJoin($id);

        //(3)获取当前ID的前一篇和后一篇
        $prevNext[] = ArticleModel::getInstance()->fetchOne("id<$id","id DESC");
        $prevNext[] = ArticleModel::getInstance()->fetchOne("id>$id","id ASC");

        //向视图赋值，并显示视图
        $this->smarty->assign(array(
            'article'	=> $article,
            'prevNext'	=> $prevNext,

        ));
        $this->smarty->display("./Index/content.html");
    }
}
