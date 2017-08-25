<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//school_sess.php を取り込む
include_once("./../inc/school_sess.php");
//ページ名
$PAGE_TITLE = "アカウント管理【学校】";

if($_REQUEST["new_submit"]||$_REQUEST["edit_submit"]){
	if($_REQUEST["edit_submit"]){
		$mode="edit";
		//対象ID
		$edit_school_id = $_REQUEST["edit_school_id"];
	}else{
		$mode="new";
		$edit_school_id = $_REQUEST["edit_school_id"];
	}

	//データ受取
	$edit_password = $_REQUEST["edit_password"];
	$edit_school_name = $_REQUEST["edit_school_name"];
	$edit_max_student_ids = $_REQUEST["edit_max_student_ids"];
	$edit_class_type = $_REQUEST["edit_class_type"];
	$edit_zip1 = $_REQUEST["edit_zip1"];
	$edit_zip2 = $_REQUEST["edit_zip2"];
	$edit_pref = $_REQUEST["edit_pref"];
	$edit_addr = $_REQUEST["edit_addr"];
	$edit_tel = $_REQUEST["edit_tel"];
	$edit_fax = $_REQUEST["edit_fax"];
	$edit_representative = $_REQUEST["edit_representative"];
	$edit_representative_email = $_REQUEST["edit_representative_email"];
	$edit_insert_date = $_REQUEST["edit_insert_date"];
	$edit_make_admin_id = $_REQUEST["edit_make_admin_id"];
	$edit_update_date = $_REQUEST["edit_update_date"];
	$edit_update_admin_id = $_REQUEST["edit_update_admin_id"];
	
	//入力チェック
	if($mode=="new"){
		//ID重複
		 $ary = array(array("empty"),array("han"),
					 array("min", 3),
					 array("max", 10));
		 $chk = new CheckError($edit_school_id, "学校ID", $ary);
		 if (strlen($chk->checkErrorAll())) {
		 	 $err[edit_school_id] = 1;
		 	 $errmsg[edit_school_id] = $chk->checkErrorAll();
		 }else{
		 	 $i_sql = "SELECT school_id FROM mtb_school WHERE school_id = '$edit_school_id' ";
		 	 $i_res = mysql_query($i_sql);
		 	 $i_cnt = mysql_num_rows($i_res);
		 	 if($i_cnt>0){
			 	 $err[edit_school_id] = 1;
			 	 $errmsg[edit_school_id] = "既に登録のある学校IDです。";
		 	 }
		 }
	 }

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
				 array("maxZen", 15));
	 $chk = new CheckError($edit_school_name, "学校名", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_school_name] = 1;
	 	 $errmsg[edit_school_name] = $chk->checkErrorAll();
	 }
	// 学校名
	 $ary = array(array("empty"),array("NGchar"),
				 array("num"));
	 $chk = new CheckError($edit_max_student_ids, "最大発行ID数", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_max_student_ids] = 1;
	 	 $errmsg[edit_max_student_ids] = $chk->checkErrorAll();
	 }
	//郵便番号上3桁
	 $ary = array(array("empty"),array("num"),
				 array("NGchar"),
				 array("min", 3),
				 array("max", 3));
	 $chk = new CheckError($edit_zip1, "郵便番号上３ケタ", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_zip1] = 1;
	 	 $errmsg[edit_zip1] = $chk->checkErrorAll();
	 }
	// 郵便番号上4桁
	 $ary = array(array("empty"),array("num"),
				 array("NGchar"),
				 array("min", 4),
				 array("max", 4));
	 $chk = new CheckError($edit_zip2, "郵便番号下４ケタ", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_zip2] = 1;
	 	 $errmsg[edit_zip2] = $chk->checkErrorAll();
	 }
	// 全角100文字以内
	 $ary = array(array("empty"),array("NGchar"),
				 array("maxZen", 100));
	 $chk = new CheckError($edit_addr, "所在地", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_addr] = 1;
	 	 $errmsg[edit_addr] = $chk->checkErrorAll();
	 }
	// 電話番号
	 $ary = array(array("empty"),array("han"),
				 array("max", 16));
	 $chk = new CheckError($edit_tel, "電話番号", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_tel] = 1;
	 	 $errmsg[edit_tel] = $chk->checkErrorAll();
	 }
	// FAX番号
	 $ary = array(array("empty"),array("han"),
				 array("max", 16));
	 $chk = new CheckError($edit_fax, "FAX番号", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_fax] = 1;
	 	 $errmsg[edit_fax] = $chk->checkErrorAll();
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
		if($mode=="new"){
			$up_sql = "INSERT INTO mtb_school (school_id, password, school_name, max_student_ids, class_type, zip1, zip2, pref, addr, tel, fax, representative, representative_email, insert_date, make_admin_id)
								 VALUES ('$edit_school_id','$edit_password','$edit_school_name','$edit_max_student_ids','$edit_class_type','$edit_zip1','$edit_zip2','$edit_pref','$edit_addr','$edit_tel','$edit_fax','$edit_representative','$edit_representative_email',now(),'$admin_id') ";
		}else{
			$up_sql = "UPDATE mtb_school SET 
					password = '$edit_password', 
					school_name = '$edit_school_name', 
					max_student_ids = '$edit_max_student_ids', 
					class_type = '$edit_class_type', 
					zip1 = '$edit_zip1', 
					zip2 = '$edit_zip2', 
					pref = '$edit_pref', 
					addr = '$edit_addr', 
					tel = '$edit_tel', 
					fax = '$edit_fax', 
					representative = '$edit_representative', 
					representative_email = '$edit_representative_email', 
					update_date = now(), 
					update_admin_id = '$admin_id' 
					WHERE school_id = '$edit_school_id' ";
		}
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
	$edit_max_student_ids = $data["max_student_ids"];
	$edit_class_type = $data["class_type"];
	$edit_zip1 = $data["zip1"];
	$edit_zip2 = $data["zip2"];
	$edit_pref = $data["pref"];
	$edit_addr = $data["addr"];
	$edit_tel = $data["tel"];
	$edit_fax = $data["fax"];
	$edit_representative = $data["representative"];
	$edit_representative_email = $data["representative_email"];
	$edit_insert_date = $data["insert_date"];
	$edit_make_admin_id = $data["make_admin_id"];
	$edit_update_date = $data["update_date"];
	$edit_update_admin_id = $data["update_admin_id"];
	
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,user-scalable=no,maximum-scale=1" />
<title><?=$PAGE_TITLE?>|<?=SET_SITE_TITLE?></title>
<meta name="keywords" content="">
<meta name="description" content="">
<link rel="shortcut icon" href="/img/icon/favicon.ico" type="image/x-icon" />
<link rel="icon" href="/img/icon/favicon.ico" type="image/x-icon" />
<link rel="apple-touch-icon" href="/img/icon/webclip.png" />
<link rel="stylesheet" media="all" type="text/css" href="./css/main.css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
<script type="text/javascript" src="./js/jquery.cookie.js"></script>
<link rel="stylesheet" type="text/css" href="/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript" src="/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="./js/main.js"></script>
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script></head>
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
							<h2><?=$PAGE_TITLE?><?if($mode=="new"){echo "新規登録";}else{echo "編集";}?></h2>
							<div class="con">
								<div class="q_box">
									<div class="q_ttl">ID</div>
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
									<div class="q_ttl">最大発行ID数</div>
									<div class="q_con"><?=$edit_max_student_ids?><input type="hidden" name="edit_max_student_ids" value="<?=$edit_max_student_ids?>" /></div>
								</div>
								<div class="q_box">
									<div class="q_ttl">クラス表示</div>
									<div class="q_con">
										<label><input type="radio" name="edit_class_type" value="1" <?if($edit_class_type==1){echo "checked";}?>/>アラビア数字（1組,2組,3組…）</label><br />
										<label><input type="radio" name="edit_class_type" value="2" <?if($edit_class_type==2){echo "checked";}?>/>アルファベット（A組,B組,C組…）</label><br />
										<label><input type="radio" name="edit_class_type" value="3" <?if($edit_class_type==3){echo "checked";}?>/>ローマ数字（Ⅰ組,Ⅱ組,Ⅲ組…）</label>
									</div>
								</div>
								<div class="q_box<?if($err[edit_zip1]==1){echo " err_bg";}?>">
									<div class="q_ttl">郵便番号</div>
									<div class="q_con">
										〒<input name="edit_zip1" type="text" size="2" value="<?=$edit_zip1?>" maxlength="3" style="width:40px;" />&nbsp;-<input name="edit_zip2" type="text" size="3" value="<?=$edit_zip2?>" maxlength="4" style="width:60px" onKeyUp="AjaxZip3.zip2addr('edit_zip1','edit_zip2','edit_pref','edit_addr','edit_addr');" />&nbsp;自動入力
										<?if($err[edit_zip1]==1){echo "<span class=\"esg\">※".$errmsg[edit_zip1]."</span>";}?>
										<?if($err[edit_zip2]==1){echo "<span class=\"esg\">※".$errmsg[edit_zip2]."</span>";}?><br />
									</div>
								</div>
								<div class="q_box<?if($err[edit_addr]==1){echo " err_bg";}?>">
									<div class="q_ttl">所在地</div>
									<div class="q_con">
										<select name="edit_pref">
<?
	foreach($PREFECTURE as $k=>$tmp){
?>
											<option value="<?=$k?>"<?if($edit_pref==$k){echo " selected";}?>><?echo $tmp;?></option>
<?
	}
?>
										</select>&nbsp;
										<input name="edit_addr" type="text" size="65" value="<?=$edit_addr?>" style="ime-mode: auto;" />
										<?if($err[edit_addr]==1){echo "<span class=\"esg\">※".$errmsg[edit_addr]."</span>";}?>
									</div>
								</div>
								<div class="q_box<?if($err[edit_tel]==1){echo " err_bg";}?>">
									<div class="q_ttl">電話番号</div>
									<div class="q_con"><input type="text" name="edit_tel" value="<?=$edit_tel?>" /><?if($err[edit_tel]==1){echo "<span class=\"esg\">※".$errmsg[edit_tel]."</span>";}?></div>
								</div>
								<div class="q_box<?if($err[edit_fax]==1){echo " err_bg";}?>">
									<div class="q_ttl">FAX番号</div>
									<div class="q_con"><input type="text" name="edit_fax" value="<?=$edit_fax?>" /><?if($err[edit_fax]==1){echo "<span class=\"esg\">※".$errmsg[edit_fax]."</span>";}?></div>
								</div>
								<div class="q_box<?if($err[edit_representative]==1){echo " err_bg";}?>">
									<div class="q_ttl">代表者</div>
									<div class="q_con"><input type="text" name="edit_representative" value="<?=$edit_representative?>" /><?if($err[edit_representative]==1){echo "<span class=\"esg\">※".$errmsg[edit_representative]."</span>";}?></div>
								</div>
								<div class="q_box<?if($err[edit_representative_email]==1){echo " err_bg";}?>">
									<div class="q_ttl">代表者Eメール</div>
									<div class="q_con"><input type="text" name="edit_representative_email" value="<?=$edit_representative_email?>" /><?if($err[edit_representative_email]==1){echo "<span class=\"esg\">※".$errmsg[edit_representative_email]."</span>";}?></div>
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