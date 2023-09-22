<?php

namespace Home\Model;

use Frame\Libs\BaseModel;

class CategoryModel extends BaseModel
{
    protected $table = "category";

    public function fetchAllWithJoin()
    {
        /**
         *聚合查询
         */
        $sql = "select category.*,count(article.id) as article_count from {$this->table} ";
        $sql .= "left join article on category.id=article.category_id ";
        $sql .= "group by category.id ";
        $sql .= "order by category.id ASC";

        return $this->pdo->fetchAll($sql);
    }

    public function categoryList($arrs, $level = 0, $pid = 0)
    {
        static $categorys = array();
        //循环原始的分类数组
        foreach ($arrs as $arr) {
            //查找下级菜单
            if ($arr['pid'] == $pid) {
                $arr['level'] = $level;
                $categorys[] = $arr;
                //递归调用
                $this->categoryList($arrs, $level + 1, $arr['id']);
            }
        }
        //返回结果
        return $categorys;
    }
}
