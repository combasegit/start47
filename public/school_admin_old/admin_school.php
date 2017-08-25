<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//school_sess.php を取り込む
include_once("./../inc/school_sess.php");
//ページ名
$PAGE_TITLE = "学校情報管理【学校基本情報】";

if($_REQUEST["edit_submit"]){
	$mode="edit";
	//対象ID
	$edit_school_id = $_REQUEST["edit_school_id"];

	//データ受取
	$edit_password = $_REQUEST["edit_password"];
	$edit_school_name = $_REQUEST["edit_school_name"];
	$edit_school_type = $_REQUEST["edit_school_type"];
	$edit_representative = $_REQUEST["edit_representative"];
	$edit_representative_email = $_REQUEST["edit_representative_email"];
	$edit_insert_date = $_REQUEST["edit_insert_date"];
	$edit_update_date = $_REQUEST["edit_update_date"];
	
	//入力チェック
	// パスワード
	 $ary = array(array("empty"),array("han"),
				 array("min", 5),
				 array("max", 20));
	 $chk = new CheckError($edit_password, "パスワード", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_password] = 1;
	 	 $errmsg[edit_password] = $chk->checkErrorAll();
	 }
	// 学校名
	 $ary = array(array("empty"),array("NGchar"),
				 array("maxZen", 20));
	 $chk = new CheckError($edit_school_name, "学校名", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_school_name] = 1;
	 	 $errmsg[edit_school_name] = $chk->checkErrorAll();
	 }
	// 代表者
	 $ary = array(array("empty"),array("NGchar"),
				 array("maxZen", 20));
	 $chk = new CheckError($edit_representative, "代表者", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_representative] = 1;
	 	 $errmsg[edit_representative] = $chk->checkErrorAll();
	 }
	// 代表者メールアドレス
	 $ary = array(array("empty"),array("email"),
				 array("NGchar"),
				 array("max", 50));
	 $chk = new CheckError($edit_representative_email, "代表者Eメール", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_representative_email] = 1;
	 	 $errmsg[edit_representative_email] = $chk->checkErrorAll();
	 }

	//すべての入力項目に誤りが無ければDB登録
	if(!is_array($err)){
			$up_sql = "UPDATE mtb_school SET 
					password = '$edit_password', 
					school_name = '$edit_school_name', 
					school_type = '$edit_school_type', 
					representative = '$edit_representative', 
					representative_email = '$edit_representative_email', 
					update_date = now() 
					WHERE school_id = '$edit_school_id' ";
		if(!( mysql_query($up_sql))){
			$err0 = 1;
			$errmsg0 = "DBの書き込みに失敗しました。お手数ですが、再度ご入力をお願いします。<br />";
		}else{
			$ok=1;
			
		}
	}
	
}else{
$mode="edit";
	//対象ID
	$edit_id = $school_id;
	//既存情報引き出し
	$sql = "select * from mtb_school where school_id = '$edit_id' AND del_flag = '0' ";
	$res = mysql_query($sql);
	$data = mysql_fetch_array($res);
	$edit_school_id = $data["school_id"];
	$edit_password = $data["password"];
	$edit_school_name = $data["school_name"];
	$edit_school_type = $data["school_type"];
	$edit_representative = $data["representative"];
	$edit_representative_email = $data["representative_email"];
	$edit_insert_date = $data["insert_date"];
	$edit_update_date = $data["update_date"];
	
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<?
//メタ情報 を取り込む
include_once("./00_meta.php");
?>
</head>
<body>
	<div id="wrapper">
<?
//ヘッダー を取り込む
include_once("./00_header.php");
?>
		<div id="middle">
<?
//MENU を取り込む
include_once("./00_menu.php");
?>
			<div id="right_main">
				<div id="breadcrumb">
					<a href="./main.php">HOME</a>　>　
					<a href="<?=basename($_SERVER['PHP_SELF'])?>"><?=$PAGE_TITLE?></a>
				</div>
				<div id="main_box">
<?
if($ok==1){
?>
					<!-- 完了画面 -->
					<div class="complete_box">
						<div class="top">登録が完了しました。</div>
						<div class="mid">
							<a href="<?=basename($_SERVER['PHP_SELF'])?>">戻る</a>
						</div>
					</div>
					<!-- //完了画面 -->
<?
}elseif($mode=="edit"){
?>
<?
	if($err0==1){
?>
					<div class="err_box">
						<div class="top">ご入力ありがとうございます。以下のエラーが発生いたしました。</div>
						<div class="mid">
							<?=$errmsg0?>
						</div>
					</div>
<?
	}
?>
					<div class="contents_box">
						<form class="form-search" action="" method="post">
							<h2><?=$PAGE_TITLE?>編集</h2>
							<div class="con">
								<div class="q_box">
									<div class="q_ttl">学校ID</div>
									<div class="q_con"><?=$edit_school_id?><input type="hidden" name="edit_school_id" value="<?=$edit_school_id?>" /></div>
								</div>
								<div class="q_box<?if($err[edit_password]==1){echo " err_bg";}?>">
									<div class="q_ttl">PW</div>
									<div class="q_con"><input type="text" name="edit_password" value="<?=$edit_password?>" /><?if($err[edit_password]==1){echo "<span class=\"esg\">※".$errmsg[edit_password]."</span>";}?></div>
								</div>
								<div class="q_box">
									<div class="q_ttl">学校名</div>
									<div class="q_con"><?=$edit_school_name?><input type="hidden" name="edit_school_name" value="<?=$edit_school_name?>" /></div>
								</div>
								<div class="q_box">
									<div class="q_ttl">学校種別</div>
									<div class="q_con">
										<?foreach($SCHOOL_TYPE_ARY as $k=>$val){?>
										<label><input type="radio" name="edit_school_type" value="<?=$k?>" <?if($edit_school_type==$k){echo "checked";}?>/><?=$val?></label><br />
										<?}?>
									</div>
								</div>
								<div class="q_box<?if($err[edit_representative]==1){echo " err_bg";}?>">
									<div class="q_ttl">代表者様</div>
									<div class="q_con"><input type="text" name="edit_representative" value="<?=$edit_representative?>" /><?if($err[edit_representative]==1){echo "<span class=\"esg\">※".$errmsg[edit_representative]."</span>";}?></div>
								</div>
								<div class="q_box<?if($err[edit_representative_email]==1){echo " err_bg";}?>">
									<div class="q_ttl">代表者様Eメール</div>
									<div class="q_con"><input type="text" name="edit_representative_email" value="<?=$edit_representative_email?>" /><?if($err[edit_representative_email]==1){echo "<span class=\"esg\">※".$errmsg[edit_representative_email]."</span>";}?></div>
								</div>
								<div class="q_box">
									<div class="q_ttl">データ登録日</div>
									<div class="q_con"><?=$edit_insert_date?><input type="hidden" name="edit_insert_date" value="<?=$edit_insert_date?>" /></div>
								</div>
								<div class="q_box">
									<div class="q_ttl">データ最終更新日</div>
									<div class="q_con"><?=$edit_update_date?><input type="hidden" name="edit_update_date" value="<?=$edit_update_date?>" /></div>
								</div>
							</div>
							<div class="submit_box">
								<button type="submit" name="edit_submit" value="edit_submit" class="btn btn-blue">　登　録　</button>
							</div>
						</form>
					</div><!--/contents_box-->
<?
}
?>

				</div>
			</div>
		</div>
<?
//フッター を取り込む
include_once("./00_footer.php");
?>
	</div>
</body>
</html>