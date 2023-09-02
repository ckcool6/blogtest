<?php

namespace Home\Model;

use Frame\Libs\Db;

final class IndexModel
{
    public function fetchAll()
    {
        $db = Db::getInstance();

        $sql = "select * from user order by id desc";

        return $db->fetchAll($sql);
    }
}