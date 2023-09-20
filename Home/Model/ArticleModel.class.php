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
}