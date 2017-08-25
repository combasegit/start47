<?php
 #セッションスタート
 session_start();
 // セッションチェック
 if(!isset($_SESSION["admin_id"])){
	 header("Location: /super_admin/index.php?err=3");
 } else {
	 $admin_id = $_SESSION["admin_id"];
	 $admin_name = $_SESSION["admin_name"];
 }
// mysqliクラスのオブジェクトを作成
$mysqli = new mysqli(SQLHOST,SQLUSER,SQLPASS,SQLDATABASE);
if ($mysqli->connect_error) {
	echo $mysqli->connect_error;
	exit();
} else {
	$mysqli->set_charset("utf8");//文字化け防止
}
 
//本日の日付を取得
$ty = date("Y");
$tm = date("m");
$td = date("d");
$honjitu = $ty."年".$tm."月".$td."日";

?>