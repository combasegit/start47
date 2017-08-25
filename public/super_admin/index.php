<?
//inc.php を取り込む
include_once("./../inc/inc.php");

#セッションスタート
session_start();
//ログインキープ用クッキー
$cookie = "SPA_LoginKeep"; // Cookieの名前

#ログアウトモード
if($_GET["logout"]){
	session_destroy();
	//ログインキープクッキーがあれば、削除
	if(isset($_COOKIE[$cookie])){
		$period = time() - 1800; // Cookieの有効期限（過去の時間）
		setcookie($cookie, "", $period, '/');
	}
}elseif(isset($_COOKIE[$cookie])){
	$login_keep_key = $_COOKIE[$cookie];
	// MySQLへの接続を確立させる
	// mysqliクラスのオブジェクトを作成
	$mysqli = new mysqli(SQLHOST,SQLUSER,SQLPASS,SQLDATABASE);
	if ($mysqli->connect_error) {
		echo $mysqli->connect_error;
		exit();
	} else {
		$mysqli->set_charset("utf8");//文字化け防止
	}
	$limit_day = date("Y-m-d", strtotime("-1 month"));
	$sql = "SELECT a.* FROM dtb_admin_login AS al, mtb_admin AS a where al.admin_id = a.admin_id AND al.login_keep_key = '$login_keep_key' AND al.insert_date >= '$limit_day' AND a.del_flag = '0' ";
	$res = $mysqli->query($sql); #echo $sql;
	$cnt = $res->num_rows;
	if($cnt>0){
		$data = $res->fetch_assoc();
		$admin_id = $data[admin_id];
		$password = $data[password];
		 #ユニークキー発行
		 $login_keep_key =mkrnd(30);
		//旧データ消去
		$del_sql = "DELETE FROM dtb_admin_login where admin_id = '".$data["admin_id"]."' ";
		$del_res = $mysqli->query($del_sql);
		//DB登録
		$up_sql = "INSERT INTO dtb_admin_login (admin_id, login_keep_key, insert_date)
							 VALUES ('".$data["admin_id"]."','$login_keep_key',now()) ";
		$up_res = $mysqli->query($up_sql);
		//■クッキー上書き保存
		$period = time() + 30*24*3600; // Cookieの有効期限(30日)
		setcookie($cookie, $login_keep_key, $period, '/');

		//管理者名
		$a_sql = "SELECT * FROM mtb_admin WHERE admin_id = '".$data["admin_id"]."' ";
		$a_res = $mysqli->query($a_sql);
		$a_data= $a_res->fetch_assoc();
		/* セッションに変数を登録 */
		$_SESSION["admin_id"] = $a_data["admin_id"];
		$_SESSION["admin_name"] = $a_data["admin_name"];
		header("Location: ./main.php");
	}

}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,user-scalable=no,maximum-scale=1" />
<title><?=SET_SITE_TITLE?></title>
<meta name="keywords" content="">
<meta name="description" content="">
<link rel="shortcut icon" href="/img/icon/favicon.ico" type="image/x-icon" />
<link rel="icon" href="/img/icon/favicon.ico" type="image/x-icon" />
<link rel="apple-touch-icon" href="/img/icon/webclip.png" />
<link rel="stylesheet" media="all" type="text/css" href="./css/main.css" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
<script type="text/javascript" src="./js/main.js"></script>
</head>
<body>
<form action="./login.php" method="POST" name="login_form">
	<div id="wrap">
<?
// HEADER 取り込み
include_once("./00_header.php");
?>
		<div id="login_box"><!-- LOGINここから -->
<?
	if ($_GET['logout'] == "1") {
?>
				<div id="msg">ログアウトしました</div>
<?
	}else
	if ($_GET['err'] == "1") {
?>
				<div id="msg">ID・PASSに誤りがあります</div>
<?
	}
?>
			<div id="inputbox">
				<input type="hidden" name="mode" value="login" />
				<div class="inp_unit">
					<div class="inp_ttl">管理ID</div>
					<div class="inp_con"><input type="text" class="input_text" name="a_id" value="<?=$_GET['a_id']?>" style="ime-mode: disabled;" tabindex="1" /></div>
				</div>
				<div class="inp_unit">
					<div class="inp_ttl">PW</div>
					<div class="inp_con"><input type="password" class="input_password" name="password" value="" tabindex="2" /></div>
				</div>
				<div class="inp_submit">
					<input type="submit" class="btn btn-blue" name="submit" tabindex="3" value=" ロ グ イ ン " />
					<p><label><input type="checkbox" name="login_keep" value="1">ログイン状態を保持する</label>　　<a href="./forget.php?a_id=<?=$_GET['a_id']?>">PWを忘れたら</a></p>
				</div>
			</div>
		</div><!-- LOGINここまで -->
	</div><!-- WRAPここまで -->
<?
// FOOTER 取り込み
include_once("./00_footer.php");
?>
</form>
<!--//////////フォーカスセット///////////-->
<script type="text/javascript">
  document.login_form.s_id.focus();
</script>
<!--//////////フォーカスセット///////////-->
</body>
</html>