<?php

namespace Frame\Vendor;

use PDO;
use Exception;
use PDOException;

final class PDOWrapper
{
    private mixed $db_type;
    private mixed $db_host;
    private mixed $db_port;
    private mixed $db_user;
    private mixed $db_pass;
    private mixed $db_name;
    private mixed $charset;
    private $pdo = null;


    public function __construct()
    {
        $this->db_type = $GLOBALS['config']['db_type'];
        $this->db_host = $GLOBALS['config']['db_host'];
        $this->db_port = $GLOBALS['config']['db_port'];
        $this->db_user = $GLOBALS['config']['db_user'];
        $this->db_pass = $GLOBALS['config']['db_pass'];
        $this->db_name = $GLOBALS['config']['db_name'];
        $this->charset = $GLOBALS['config']['charset'];

        $this->createPDO();
        $this->setErrorMode();

    }

    private function createPDO(): void
    {

        try {

            $dsn = "{$this->db_type}:host={$this->db_host};port={$this->db_port};";
            $dsn .= "dbname={$this->db_name};charset={$this->charset}";

            $this->pdo = new PDO($dsn, $this->db_user, $this->db_pass);

        } catch (Exception $e) {

            echo "<h2>PDO对象创建失败</h2>";
            echo "错误编号：" . $e->getCode();
            echo "<br>错误行号：" . $e->getLine();
            echo "<br>错误文件：" . $e->getFile();
            echo "<br>错误信息：" . $e->getMessage();
            die();
        }
    }

    private function setErrorMode(): void
    {
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function exec($sql)
    {
        try {
            return $this->pdo->exec($sql);
        } catch (PDOException $e) {
            $this->showMsg($e);
        }
        return 0;
    }

    //获取单行数据
    public function fetchOne($sql)
    {
        try {
            $PDOStatement = $this->pdo->query($sql);
            return $PDOStatement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->showMsg($e);
        }
        return 0;
    }

    //获取多行
    public function fetchAll($sql)
    {
        try {
            $PDOStatement = $this->pdo->query($sql);
            return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->showMsg($e);
        }
        return 0;
    }

    //获取记录数
    public function rowCount($sql)
    {
        try {
            $PDOStatement = $this->pdo->query($sql);
            return $PDOStatement->rowCount();
        } catch (PDOException $e) {
            $this->showMsg($e);
        }
        return 0;
    }

    private function showMsg($e)
    {
        echo "<h2>SQL语句执行失败</h2>";
        echo "错误编号：" . $e->getCode();
        echo "<br>错误行号：" . $e->getLine();
        echo "<br>错误文件：" . $e->getFile();
        echo "<br>错误信息：" . $e->getMessage();
        die();
    }

}