<?php

namespace Home\Model;

use Frame\Libs\BaseModel;

class ArticleModel extends BaseModel
{
    protected $table = 'article';

    public function fetchAllWithCount()
    {
        $sql = "select date_format(from_unixtime(addate),'%Y年%m月') as yearmonth, ";
        $sql .= "count(id) as article_count from {$this->table} ";
        $sql .= "group by yearmonth ";
        $sql .= "order by yearmonth DESC";

        return $this->pdo->fetchAll($sql);
    }

    public function fetchAllWithJoin($where, $startrow, $pagesize)
    {
        $sql = "select article.*, user.name, category.classname from {$this->table} ";
        $sql .= "left join user on article.user_id=user.id ";
        $sql .= "left join category on article.category_id=category.id ";
        $sql .= "where {$where} ";
        $sql .= "order by article.id DESC ";
        $sql .= "limit {$startrow},{$pagesize}";

        return $this->pdo->fetchAll($sql);
    }
}