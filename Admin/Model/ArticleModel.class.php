<?php

namespace Admin\Model;

use Frame\Libs\BaseModel;

class ArticleModel extends BaseModel
{
    protected $table = "article";

    public function fetchAllWithJoin($startrow = 0, $pagesize = 10)
    {
        //构建连表查询的sql语句
        $sql = "select article.*,category.classname,user.username from {$this->table} "; //加空格
        $sql .= "left join `category` on article.category_id=category.id ";//加空格
        $sql .= "left join `user` on article.user_id=user.id "; //加空格
        $sql .= "order by article.orderby ASC,article.id DESC "; //加空格
        $sql .= "limit {$startrow},{$pagesize}";

        //返回二维数组
        return $this->pdo->fetchAll($sql);

    }
}