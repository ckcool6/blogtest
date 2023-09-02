<?php

namespace Admin\Controller;

use Admin\Model\IndexModel;

final class IndexController
{
    public function index()
    {
        $modelObj = new IndexModel();

        //get data
        $arr = $modelObj->fetchAll();

/*        echo "<pre>";
        var_dump($arr);
        echo "</pre>";*/

        //show view html
        include VIEW_PATH . "index.html";
    }
}
