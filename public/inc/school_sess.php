<?php
 #セッションスタート
 session_start();
 // セッションチェック
 if(!isset($_SESSION["school_id"])){
	 header("Location: /school_admin/index.php?err=3");
 } else {
	 $school_id = $_SESSION["school_id"];
	 $school_name = $_SESSION["school_name"];
	 $contract_rank = $_SESSION["contract_rank"];
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