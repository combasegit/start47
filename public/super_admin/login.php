<?php
//inc.php を取り込む
include_once("./../inc/inc.php");

 #セッションスタート
 session_start();

 $a_id = "";
 $password = "";

 #メインプログラム
 if(hsc($_POST["mode"]) == "login"){
	 $a_id = hsc($_POST["a_id"]);
	 $password = hsc($_POST["password"]);
	 $login_keep = hsc($_POST["login_keep"]);
 }else{
	 if (hsc($_GET["mode"]) == "login") {
		$a_id = hsc($_GET["a_id"]);
		$password = hsc($_GET["password"]);
		$login_keep = hsc($_GET["login_keep"]);
	 } else {
	 	 header("Location: ./index.php?err=1&a_id=".$a_id);
	 	 exit();
	 }
 }

// mysqliクラスのオブジェクトを作成
$mysqli = new mysqli(SQLHOST,SQLUSER,SQLPASS,SQLDATABASE);
if ($mysqli->connect_error) {
	echo $mysqli->connect_error;
	exit();
} else {
	$mysqli->set_charset("utf8");//文字化け防止
}

$sql = "SELECT * FROM mtb_admin WHERE admin_id = '$a_id' AND password = '$password' AND del_flag = '0' ";
$res = $mysqli->query($sql);
$cnt = $res->num_rows;
if ($cnt == 1) {
	/*ログイン保持*/
	if($login_keep>0){
		 #ユニークキー発行
		 $login_keep_key =mkrnd(30);
		//旧データ消去
		$del_sql = "DELETE FROM dtb_admin_login where admin_id = '$a_id' ";
		$del_res = $mysqli->query($del_sql);
		//DB登録
		$up_sql = "INSERT INTO dtb_admin_login (admin_id, login_keep_key, insert_date)
							 VALUES ('$a_id','$login_keep_key',now()) ";
		$up_res = $mysqli->query($up_sql);
		//■クッキー上書き保存
		$cookie = "SPA_LoginKeep"; // Cookieの名前
		$period = time() + 30*24*3600; // Cookieの有効期限(30日)
		setcookie($cookie, $login_keep_key, $period, '/');

	}

	/* セッションに変数を登録 */
	$data = $res->fetch_assoc();
	$_SESSION["admin_id"] = $a_id;
	$_SESSION["admin_name"] = $data["admin_name"];
	header("Location: ./main.php");
} else {
	 	 header("Location: ./index.php?err=2&a_id=".$a_id);
}

exit();

?>