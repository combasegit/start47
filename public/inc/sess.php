<?php
// mysqliクラスのオブジェクトを作成
$mysqli = new mysqli(SQLHOST,SQLUSER,SQLPASS,SQLDATABASE);
if ($mysqli->connect_error) {
	echo $mysqli->connect_error;
	exit();
} else {
	$mysqli->set_charset("utf8");//文字化け防止
}

#セッションスタート
session_start();

//本日の日付を取得
$ty = date("Y");
$tm = date("m");
$td = date("d");
$tw = date("w");
$honjitu = $ty."年".$tm."月".$td."日";
$honjitu2 = $ty."年".$tm."月".$td."日(".$dow_ary[$tw].")";

?>