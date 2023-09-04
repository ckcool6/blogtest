<?php

namespace Home\Controller;

use Home\Model\IndexModel;

final class IndexController
{
    public function index()
    {

        $modelObj = IndexModel::getInstance();
        //get data
        $arr = $modelObj->fetchAll();

        echo "<pre>";
        var_dump($arr);
        echo "</pre>";

        //show view html
        //include VIEW_PATH . "index.html";
    }
}
