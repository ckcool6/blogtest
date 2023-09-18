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
}
