<?php

namespace Admin\Model;

use Frame\Libs\BaseModel;

class CategoryModel extends BaseModel
{
    protected $table = "category";

    public function categoryList($arrs, $level = 0, $id = 0)
    {
        static $categorys = array();

        foreach ($arrs as $arr) {
            //当id=pid的时候
            if ($arr['pid'] == $id) {
                //增加一个新字段level
                $arr['level'] = $level;
                //加到结果数组里
                $categorys[] = $arr;
                //层级level加一
                $this->categoryList($arrs, $level + 1, $arr['id']);
            }
        }

        return $categorys;
    }

}