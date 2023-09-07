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

    public function add()
    {
        $this->smarty->display("./User/add.html");
    }

    //register
    public function insert()
    {
        //获取表单数据
        $data['username'] = $_POST['username'];
        $data['password'] = md5($_POST['password']);
        $data['name'] = $_POST['name'];
        $data['tel'] = $_POST['tel'];
        $data['status'] = $_POST['status'];
        $data['role'] = $_POST['role'];
        $data['addate'] = time();

        //是否重复注册
        if (UserModel::getInstance()->rowCount("username='{$data['username']}'")) {
            $this->jump("用户名{$data['username']}已注册", "?c=User");
        }

        //判断两次输入密码是否一致
        if ($data['password'] != md5($_POST['confirmpwd'])) {
            $this->jump("两次输入密码不一致", "?c=User");
        }

        if (UserModel::getInstance()->insert($data)) {
            $this->jump("注册成功", "?c=User");
        } else {
            $this->jump("注册失败", "?c=User");
        }
    }

}