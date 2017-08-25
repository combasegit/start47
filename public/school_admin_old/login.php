<?php
//inc.php を取り込む
include_once("./../inc/inc.php");

 #セッションスタート
 session_start();

 $id = "";
 $pass = "";

 #メインプログラム
 if(hsc($_POST["mode"]) == "login"){
	 $s_id = hsc($_POST["s_id"]);
	 $password = hsc($_POST["password"]);
	 $login_keep = hsc($_POST["login_keep"]);
 }else{
	 if (hsc($_GET["mode"]) == "login") {
		$s_id = hsc($_GET["s_id"]);
		$password = hsc($_GET["password"]);
		$login_keep = hsc($_GET["login_keep"]);
	 } else {
	 	 header("Location: ./index.php?err=1&s_id=".$s_id);
	 	 exit();
	 }
 }

// MySQLへの接続を確立させる
$con = mysql_connect(SQLHOST, SQLUSER, SQLPASS);
mysql_query("SET NAMES utf8",$con); //クエリの文字コードを設定
// 接続を確立させたらデータベースを選択する
mysql_select_db(SQLDATABASE);

$sql = "select * from mtb_school where school_id = '$s_id' and password = '$password' ";
$rs = mysql_query($sql);
$data = mysql_fetch_array($rs);
$mycnt = mysql_num_rows($rs);
if ($mycnt == 1) {
	/*ログイン保持*/
	if($login_keep>0){
		 #ユニークキー発行
		 $login_keep_key =mkrnd(30);
		//旧データ消去
		$del_sql = "DELETE FROM dtb_school_login where school_id = '$s_id' ";
		$del_res = mysql_query($del_sql);
		//DB登録
		$up_sql = "INSERT INTO dtb_school_login (school_id, login_keep_key, insert_date)
							 VALUES ('$s_id','$login_keep_key',now()) ";
		$up_res = mysql_query($up_sql);
		//■クッキー保存
		$cookie = "T_LoginKeep"; // Cookieの名前
		$period = time() + 30*24*3600; // Cookieの有効期限(30日)
		setcookie($cookie, $login_keep_key, $period, '/');

	}

	/* セッションに変数を登録 */
	$_SESSION["school_id"] = $s_id;
	$_SESSION["school_name"] = $data["school_name"];
	header("Location: ./main.php");
} else {
	 	 header("Location: ./index.php?err=2&s_id=".$s_id);
}

exit();

?>