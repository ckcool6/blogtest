<?php
use Frame\Frame;

//目录分割符
const DS = DIRECTORY_SEPARATOR;
//根目录
define("ROOT_PATH", getcwd() . DS);
//admin dir
const APP_PATH = ROOT_PATH . "Admin" . DS;

//frame init
require_once(ROOT_PATH . "Frame" . DS . "Frame.class.php");
//method init
Frame::run();
