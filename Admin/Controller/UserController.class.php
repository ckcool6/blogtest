<?php

namespace Admin\Controller;

use Admin\Model\UserModel;
use Frame\Libs\BaseController;
use Frame\Vendor\Captcha;

class UserController extends BaseController
{
    public function index()
    {
        //权限验证
        $this->denyAccess();

        $modelObj = UserModel::getInstance();
        $users = $modelObj->fetchAll();

        //show
        $this->smarty->assign("users", $users);
        $this->smarty->display("./User/index.html");

    }

    public function delete()
    {
        $this->denyAccess();

        $id = $_GET['id'];
        if (UserModel::getInstance()->delete($id)) {
            $this->jump("id={$id}的记录删除成功", "?c=User");
        } else {
            $this->jump("id={$id}的记录删除失败", "?c=User");
        }
    }

    public function add()
    {
        $this->denyAccess();

        $this->smarty->display("./User/add.html");
    }

    //register
    public function insert()
    {
        $this->denyAccess();

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

    public function edit()
    {
        $this->denyAccess();

        $id = $_GET['id'];
        $user = UserModel::getInstance()->fetchOne("id={$id}");
        $this->smarty->assign("user", $user);
        $this->smarty->display("./User/edit.html");
    }

    public function update()
    {
        $this->denyAccess();

        $id = $_POST['id'];
        $data['name'] = $_POST['name'];
        $data['tel'] = $_POST['tel'];
        $data['status'] = $_POST['status'];
        $data['role'] = $_POST['role'];

        //password是否为空
        if (!empty($_POST['password'] && !empty($_POST['confirmpwd']))) {
            //两次输入是否一致
            if ($_POST['password'] == $_POST['confirmpwd']) {
                $data['password'] = md5($_POST['password']);
            }
        }

        if (UserModel::getInstance()->update($data, $id)) {
            $this->jump("id={$id}记录更新成功", "?c=User");
        } else {
            $this->jump("id={$id}记录更新失败", "?c=User");
        }
    }

    public function login()
    {
        $this->smarty->display("./User/login.html");
    }

    public function loginCheck()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $verify = $_POST['verify'];

        //判断验证码与服务器是否一致
        if ($verify != $_SESSION['captcha']) {
            $this->jump("验证码错误", "?c=User&a=login");
        }

        //判断用户名密码与数据库是否一致
        $user = UserModel::getInstance()->fetchOne("username='$username' and password='$password'");
        if (!$user) {
            $this->jump("用户名或密码不正确", "?c=User&a=login");
        }

        //判断是`停用`还是`正常`
        if (empty($user['status'])) {
            $this->jump("账号已停用", "?c=User&a=login");
        }

        //更新last_login_ip,time,times字段
        $date['last_login_ip'] = $_SERVER['REMOTE_ADDR'];
        $date['last_login_time'] = time();
        $date['login_times'] = $user['login_times'] + 1;

        if (!UserModel::getInstance()->update($date, $user['id'])) {
            $this->jump("用户资料更新失败", "?c=User&a=login");
        }

        //将用户的状态存入Session
        $_SESSION['uid'] = $user['id'];
        $_SESSION['username'] = $username;

        //跳转后台首页
        header("location:./admin.php");
    }

    //验证码
    public function captcha()
    {
        $captcha = new Captcha();
        //将验证码保存到session
        $_SESSION['captcha'] = $captcha->getCode();

    }

    public function logout()
    {
        //delete session date
        unset($_SESSION['username']);
        unset($_SESSION['uid']);

        session_destroy();
        setcookie(session_name(),false);

        header("location:admin.php?c=User&a=login");
    }
}