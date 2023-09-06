<?php

namespace Admin\Controller;

use Admin\Model\UserModel;
use Frame\Libs\BaseController;

class UserController extends BaseController
{
    public function index()
    {
        $modelObj = UserModel::getInstance();
        $users = $modelObj->fetchAll();

        //show
        $this->smarty->assign("users", $users);
        $this->smarty->display("./User/index.html");

    }
}