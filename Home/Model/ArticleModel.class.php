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

    public function fetchOneWithJoin($id)
    {
        //构建连表查询的SQL语句
        $sql = "SELECT article.*,user.name,category.classname FROM {$this->table} ";
        $sql .= "LEFT JOIN user ON article.user_id=user.id ";
        $sql .= "LEFT JOIN category ON article.category_id=category.id ";
        $sql .= "WHERE article.id={$id} ";

        //执行SQL语句，并返回一维数组
        return $this->pdo->fetchOne($sql);
    }

    //更新阅读数
    public function updateRead($id)
    {
        //构建更新的SQL语句
        $sql = "UPDATE {$this->table} SET `read` = `read` + 1 WHERE id={$id}";
        //执行SQL语句
        return $this->pdo->exec($sql);
    }

}