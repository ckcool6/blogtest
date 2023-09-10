<?php

namespace Frame;

final class Frame
{
    public static function run()
    {
        self::initConfig();
        self::initRoute();
        self::initConst();
        self::initAutoload();
        self::initDispatch();
    }

    private static function initConfig()
    {
        //开启session
        session_start();
        //添加一个名为config的全局数组变量
        $GLOBALS['config'] = require_once(APP_PATH . "Conf" . DS . "Config.php");
    }

    //默认路由参数
    private static function initRoute()
    {
        $p = $GLOBALS['config']['default_platform'];
        $c = isset($_GET['c']) ? $_GET['c'] : $GLOBALS['config']['default_controller'];
        $a = isset($_GET['a']) ? $_GET['a'] : $GLOBALS['config']['default_action'];

        define("PLAT", $p);
        define("CONTROLLER", $c);
        define("ACTION", $a);
    }

    private static function initConst()
    {
        define("FRAME_PATH", ROOT_PATH . "Frame" . DS);
        define("VIEW_PATH", APP_PATH . "View" . DS);
    }

    private static function initAutoload()
    {
        spl_autoload_register(
            function ($className) {
                $filename = ROOT_PATH . str_replace("\\", DS, $className) . ".class.php";
                if (file_exists($filename)) {
                    require_once($filename);
                }
            }
        );
    }

    private static function initDispatch()
    {
        $c =  PLAT . "\\" . "Controller" . "\\" . CONTROLLER . "Controller";
        $controllerObj = new $c();
        $a = ACTION;
        $controllerObj->$a();
    }
}