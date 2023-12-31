<?php

namespace Frame\Libs;

use Frame\Vendor\Smarty;

abstract class BaseController
{
    protected $smarty = null;

    public function __construct()
    {

        $smarty = new Smarty();

        //设置smarty模板语法
        $smarty->left_delimiter = "<{";
        $smarty->right_delimiter = "}>";
        //设置smarty编译目录
        $smarty->setCompileDir(sys_get_temp_dir() . DS . "view_c" . DS);
        //设置视图目录
        $smarty->setTemplateDir(VIEW_PATH);

        $this->smarty = $smarty;
    }

    protected function jump($message, $url = '?', $time = 3)
    {

        echo "<h2 style='color: brown'>{$message}</h2>";
        header("refresh:{$time};url={$url}");
        die();
    }

    protected function denyAccess()
    {
        if (empty($_SESSION['username'])) {
            $this->jump("请先登录", "?c=User&a=login");
        }
    }

}
