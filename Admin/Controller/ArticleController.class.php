<?php

namespace Admin\Controller;

use Admin\Model\ArticleModel;
use Admin\Model\CategoryModel;
use Frame\Libs\BaseController;
use Frame\Vendor\Pager;

class ArticleController extends BaseController
{
    public function index()
    {
        $categorys = CategoryModel::getInstance()->categoryList(CategoryModel::getInstance()->fetchAll("id ASC"));

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
        echo "sql搜索语句：" . $where;

        /**
         * 构造page类参数
         */
        $pagesize = 5;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $startrow = ($page - 1) * $pagesize; //开始行号
        $records = ArticleModel::getInstance()->rowCount($where);
        $params = array('c' => CONTROLLER, 'a' => ACTION); //附加参数

        /**
         * 搜索分页参数
         */
        if (!empty($_REQUEST['category_id'])) {
            $params['category_id'] = $_REQUEST['category_id'];
        }
        if (!empty($_REQUEST['keyword'])) {
            $params['keyword'] = $_REQUEST['keyword'];
        }

        /**
         * 创建分页对象
         */
        $pageObj = new Pager($records, $pagesize, $page, $params);
        $pageStr = $pageObj->showPage();

        $articles = ArticleModel::getInstance()->fetchAllWithJoin($where, $startrow, $pagesize);

        $this->smarty->assign(array(
            'categorys' => $categorys,
            'articles' => $articles,
            'pageStr' => $pageStr,
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
