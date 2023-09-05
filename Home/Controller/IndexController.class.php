<?php

namespace Home\Controller;

use Frame\Libs\BaseController;
use Home\Model\IndexModel;

final class IndexController extends BaseController
{
    public function index()
    {

        $modelObj = IndexModel::getInstance();
        //get data
        $arr = $modelObj->fetchAll();

        //show view html
        $this->smarty->assign("arr", $arr);
        $this->smarty->display("index.html");
    }
}
