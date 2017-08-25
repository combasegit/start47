<?
//inc.php を取り込む
include_once("./../inc/inc.php");

#セッションスタート
session_start();
//ログインキープ用クッキー
$cookie = "T_LoginKeep"; // Cookieの名前

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
	$con = mysql_connect(SQLHOST, SQLUSER, SQLPASS);
	mysql_query("SET NAMES utf8",$con); //クエリの文字コードを設定
	// 接続を確立させたらデータベースを選択する
	mysql_select_db(SQLDATABASE);
	$limit_day = date("Y-m-d", strtotime("-1 month"));
	$sql = "SELECT a.* FROM dtb_teacher_login AS al, mtb_teacher AS a where al.teacher_id = a.teacher_id AND al.login_keep_key = '$login_keep_key' AND al.insert_date >= '$limit_day' AND a.del_flag = '0' ";
	$rs = mysql_query($sql);#echo $sql;
	$mycnt = mysql_num_rows($rs);
	if($mycnt>0){
		$data = mysql_fetch_array($rs);
		$email = $data[teacher_email];
		$password = $data[password];
		 #ユニークキー発行
		 $login_keep_key =mkrnd(30);
		//旧データ消去
		$del_sql = "DELETE FROM dtb_teacher_login where teacher_id = '".$data["teacher_id"]."' ";
		$del_res = mysql_query($del_sql);
		//DB登録
		$up_sql = "INSERT INTO dtb_teacher_login (teacher_id, login_keep_key, insert_date)
							 VALUES ('".$data["teacher_id"]."','$login_keep_key',now()) ";
		$up_res = mysql_query($up_sql);
		//■クッキー上書き保存
		$period = time() + 30*24*3600; // Cookieの有効期限(30日)
		setcookie($cookie, $login_keep_key, $period, '/');

		//学校名
		$a_sql = "SELECT * FROM mtb_school WHERE school_id = '".$data["school_id"]."' ";
		$a_res = mysql_query($a_sql);
		$a_data = mysql_fetch_array($a_res);

		/* セッションに変数を登録 */
		$_SESSION["school_id"] = $data["school_id"];
		$_SESSION["school_name"] = $a_data["school_name"];
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
					<div class="inp_ttl">学校ID</div>
					<div class="inp_con"><input type="text" class="input_text" name="s_id" value="<?=$_GET['s_id']?>" style="ime-mode: disabled;" tabindex="1" /></div>
				</div>
				<div class="inp_unit">
					<div class="inp_ttl">PW</div>
					<div class="inp_con"><input type="password" class="input_password" name="password" value="" tabindex="2" /></div>
				</div>
				<div class="inp_submit">
					<input type="submit" class="btn btn-blue" name="submit" tabindex="3" value=" ロ グ イ ン " />
					<p><label><input type="checkbox" name="login_keep" value="1">ログイン状態を保持する</label>　　<a href="./forget.php?id=<?=$_GET['id']?>">PWを忘れたら</a></p>
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