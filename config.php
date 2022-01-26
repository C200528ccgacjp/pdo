<?php
/* データベース定義 */
define('DB_HOST','localhost');
define('DB_NAME','lesson2');
define('DB_CHAR','utf8mb4');
define('DSN','mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHAR.'');
define('DB_USER','root');
define('DB_PASS','');
/* PHPのエラーを表示するように設定 */
error_reporting(E_ALL & ~E_NOTICE);
