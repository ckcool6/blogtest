<?php

namespace Admin\Controller;

use Frame\Libs\BaseController;

class IndexController extends BaseController
{
    public function index()
    {
        $this->denyAccess();

        $this->smarty->display("./Index/index.html");
    }

    public function top()
    {
        $this->denyAccess();

        $this->smarty->display("./Index/top.html");
    }

    public function left()
    {
        $this->denyAccess();

        $this->smarty->display("./Index/left.html");
    }

    public function center()
    {
        $this->denyAccess();

        $this->smarty->display("./Index/center.html");
    }

    public function main()
    {
        $this->denyAccess();

        $this->smarty->display("./Index/main.html");
    }
}