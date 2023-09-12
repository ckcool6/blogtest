<?php

namespace Home\Model;

use Frame\Libs\BaseModel;
use Frame\Libs\Db;

final class IndexModel extends BaseModel
{
    public function fetchAll($orderby="id DESC")
    {
        $sql = "select * from user order by id desc";

        return $this->pdo->fetchAll($sql);
    }
}