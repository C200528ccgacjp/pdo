<?php
require_once("config.php");
function db_conn() {
    /* データベースへ接続　*/
    try {
        $dbh = new PDO(DSN,DB_USER,DB_PASS);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    } catch (PDOException $e){
        echo $e->getMessage();   //デバッグ用
        exit;
    }
    return $dbh;
}
