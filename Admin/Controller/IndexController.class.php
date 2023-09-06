<?php

namespace Admin\Controller;

use Frame\Libs\BaseController;

class IndexController extends BaseController
{
    public function index()
    {
        $this->smarty->display("./Index/index.html");
    }

    public function top()
    {
        $this->smarty->display("./Index/top.html");
    }

    public function left()
    {
        $this->smarty->display("./Index/left.html");
    }

    public function center()
    {
        $this->smarty->display("./Index/center.html");
    }

    public function main()
    {
        $this->smarty->display("./Index/main.html");
    }
}