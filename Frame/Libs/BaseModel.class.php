<?php

namespace Frame\Libs;

use Frame\Vendor\PDOWrapper;

abstract class BaseModel
{
    protected $pdo = null;

    public function __construct()
    {
        $this->pdo = new PDOWrapper();
    }

    //生产模型类对象的工厂方法
    public static function getInstance()
    {
        $modelClassName = get_called_class();
        return new $modelClassName();
    }

}