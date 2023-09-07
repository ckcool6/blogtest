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

    public function delete()
    {
        $id = $_GET['id'];
        if (UserModel::getInstance()->delete($id)) {
            $this->jump("id={$id}的记录删除成功", "?c=User");
        } else {
            $this->jump("id={$id}的记录删除失败", "?c=User");
        }
    }

}