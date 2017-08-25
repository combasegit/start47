<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//school_sess.php を取り込む
include_once("./../inc/school_sess.php");
//ページ名
$PAGE_TITLE = "学校情報管理【キャンパス情報】";

//この学校のキャンパス取得
$d_sql = "SELECT * FROM mtb_campus WHERE school_id = '$school_id' AND del_flag = '0' ";
$d_res = mysql_query($d_sql);
$d_cnt = mysql_num_rows($d_res);

if($_REQUEST["del"]){
$mode="search";
	if($_REQUEST["del"]){
		//削除対象ID
		$del_id = $_REQUEST["del"];
		//del_flag立てる
		$ed_sql = "UPDATE mtb_campus SET del_flag = '1' WHERE school_id = '$school_id' AND campus_id = '$del_id' ";
		if(!( mysql_query($ed_sql))){
			$del_err = 1;
			$del_errmsg = "削除に失敗しました。お手数ですが、再度ご入力をお願いします。<br />";
		}else{
		 	 $ok=1;
		}

	}

}elseif($_REQUEST["new_submit"]||$_REQUEST["edit_submit"]){
	if($_REQUEST["edit_submit"]){
		$mode="edit";
		//対象ID
		$edit_campus_id = $_REQUEST["edit_campus_id"];
	}else{
		$mode="new";

	}
	//データ受取
	$edit_campus_name = $_REQUEST["edit_campus_name"];
	$edit_pref = $_REQUEST["edit_pref"];
	$edit_zip1 = $_REQUEST["edit_zip1"];
	$edit_zip2 = $_REQUEST["edit_zip2"];
	$edit_address = $_REQUEST["edit_address"];
	$edit_tel = $_REQUEST["edit_tel"];
	$edit_insert_date = $_REQUEST["edit_insert_date"];
	$edit_update_date = $_REQUEST["edit_update_date"];
	
	//入力チェック
	 $ary = array(array("empty"),array("NGchar"),
				 array("maxZen", 10));
	 $chk = new CheckError($edit_campus_name, "キャンパス名", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_teacher_name] = 1;
	 	 $errmsg[edit_teacher_name] = $chk->checkErrorAll();
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
	 $chk = new CheckError($edit_address, "所在地", $ary);
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

	//すべての入力項目に誤りが無ければDB登録
	if(!is_array($err)){
		if($mode=="new"){
			//campus_idの新規裁番
			$idset_flg = "ng";
			while($idset_flg == "ng"){
				$newid = mkrnd(6); // $idに6桁の乱数を与える
				$cntsql = "select count(*) as cnt from mtb_campus where campus_id = '$newid'";
				$cntrs = mysql_query($cntsql);
				$cntdata = mysql_fetch_array($cntrs);
				if($cntdata["cnt"] == 0){
					$idset_flg = "ok";
				}
			}
			$up_sql = "INSERT INTO mtb_campus (campus_id,school_id, campus_name, pref, zip1, zip2, address, tel, insert_date)
								 VALUES ('$newid','$school_id','$edit_campus_name','$edit_pref','$edit_zip1','$edit_zip2','$edit_address','$edit_tel',now()) ";
			//新規登録のみメール通知が動くフラグ
			$send_mail_flag = "1";
		}else{
			$up_sql = "UPDATE mtb_campus SET 
					school_id = '$school_id', 
					campus_name = '$edit_campus_name', 
					pref = '$edit_pref', 
					zip1 = '$edit_zip1', 
					zip2 = '$edit_zip2', 
					address = '$edit_address', 
					tel = '$edit_tel', 
					update_date = now() 
					WHERE campus_id = '$edit_campus_id' ";
		}
		if(!( mysql_query($up_sql))){
			$err0 = 1;
			$errmsg0 = "DBの書き込みに失敗しました。お手数ですが、再度ご入力をお願いします。<br />";
		}else{
			$ok=1;
			
		}
	}
	
	
}elseif($_REQUEST["edit"]){
$mode="edit";
	//対象ID
	$edit_id = $_REQUEST["edit"];
	//既存情報引き出し
	$sql = "select * from mtb_campus where campus_id = '$edit_id' ";
	$res = mysql_query($sql);
	$data = mysql_fetch_array($res);
	$edit_campus_id = $edit_id;
	$edit_campus_name = $data["campus_name"];
	$edit_pref = $data["pref"];
	$edit_zip1 = $data["zip1"];
	$edit_zip2 = $data["zip2"];
	$edit_address = $data["address"];
	$edit_tel = $data["tel"];
	$edit_insert_date = $data["insert_date"];
	$edit_update_date = $data["update_date"];

	
}elseif($_REQUEST["new"]){
$mode="new";
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<?
//メタ情報 を取り込む
include_once("./00_meta.php");
?>
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
<script type="text/javascript">
<!--
$(function(){
    $('.zipnumber').bind('keyup',function(){
        var thisValueLength = $(this).val().length;
        if (thisValueLength >= 3) {
            $(this).next().focus();
        }
    });
});
-->
</script>
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
if($mode!="edit"&&$mode!="new"){
?>
					<div class="add_btn_box">
						<form class="form-new" action="" method="post">
							<button type="submit" name="new" value="1" class="btn btn-green">　新規登録　</button>
						</form>
					</div>
					<?if($ok==1){?><p style="color:#0000ff;">削除に成功しました。</p><?}?>
					<?if($del_err==1){?><p style="color:#ff0000;"><?=$del_errmsg?></p><?}?>
					<div class="contents_box">
						<h2>登録済みキャンパス一覧</h2>
						<div class="con">
						<?if($d_cnt==0){?>
							<p>現在、キャンパスの登録がありません</p>
						<?}else{?>
							<table>
								<thead>
									<tr>
										<th>ID</th>
										<th>キャンパス名</th>
										<th>都道府県</th>
										<th>所在地</th>
										<th>電話番号</th>
										<th>編集</th>
									</tr>
								</thead>
								<tbody>
<?
while($d_data = mysql_fetch_array($d_res)){
?>
									<tr>
										<td><?=$d_data["campus_id"]?></td>
										<td><?=$d_data["campus_name"]?></td>
										<td class="center"><?=$PREFECTURE[$d_data["pref"]]?></td>
										<td><?=$d_data["address"]?></td>
										<td><?=$d_data["tel"]?></td>
										<td class="center">
											<form action="" method="post">
												<button type="submit" name="edit" value="<?=$d_data["campus_id"]?>" class="btn btn-blue">編集</button>
												<button type="submit" name="del" value="<?=$d_data["campus_id"]?>" class="btn btn-red" onclick="return confirm('本当に削除しますか？')">削除</button>
											</form>
										</td>
									</tr>
<?
}
?>
								</tbody>
							</table>
						<?}?>
						</div>
						<br style="clear:left;" />
					</div><!--/contents_box-->
<?
}
?>
<?
if($ok==1){
?>
					<!-- 完了画面 -->
					<div class="complete_box">
						<div class="top">登録が完了しました。</div>
						<div class="mid">
							<a href="<?=basename($_SERVER['PHP_SELF'])?>">一覧画面へ戻る</a>
						</div>
					</div>
					<!-- //完了画面 -->
<?
}elseif($mode=="edit"||$mode=="new"){
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
								<?if($mode=="edit"){?>
								<div class="q_box">
									<div class="q_ttl">ID</div>
									<div class="q_con"><?=$edit_campus_id?><input type="hidden" name="edit_campus_id" value="<?=$edit_campus_id?>" /></div>
								</div>
								<?}?>
								<div class="q_box<?if($err[edit_campus_name]==1){echo " err_bg";}?>">
									<div class="q_ttl">キャンパス名</div>
									<div class="q_con"><input type="text" name="edit_campus_name" value="<?=$edit_campus_name?>" /><?if($err[edit_campus_name]==1){echo "<span class=\"esg\">※".$errmsg[edit_campus_name]."</span>";}?></div>
								</div>
								<div class="q_box<?if($err[edit_zip1]==1){echo " err_bg";}?>">
									<div class="q_ttl">郵便番号</div>
									<div class="q_con">
										〒<input name="edit_zip1" class="zipnumber" type="text" size="2" value="<?=$edit_zip1?>" maxlength="3" style="width:40px;" />&nbsp;-<input name="edit_zip2" type="text" size="3" value="<?=$edit_zip2?>" maxlength="4" style="width:60px" onKeyUp="AjaxZip3.zip2addr('edit_zip1','edit_zip2','edit_pref','edit_address','edit_address');" />&nbsp;自動入力
										<?if($err[edit_zip1]==1){echo "<span class=\"esg\">※".$errmsg[edit_zip1]."</span>";}?>
										<?if($err[edit_zip2]==1){echo "<span class=\"esg\">※".$errmsg[edit_zip2]."</span>";}?><br />
									</div>
								</div>
								<div class="q_box<?if($err[edit_address]==1){echo " err_bg";}?>">
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
										<input name="edit_address" type="text" size="65" value="<?=$edit_address?>" style="ime-mode: auto;" />
										<?if($err[edit_address]==1){echo "<span class=\"esg\">※".$errmsg[edit_address]."</span>";}?>
									</div>
								</div>
								<div class="q_box<?if($err[edit_tel]==1){echo " err_bg";}?>">
									<div class="q_ttl">電話番号</div>
									<div class="q_con"><input type="text" name="edit_tel" value="<?=$edit_tel?>" /><?if($err[edit_tel]==1){echo "<span class=\"esg\">※".$errmsg[edit_tel]."</span>";}?></div>
								</div>
								<?if($mode=="edit"){?>
								<div class="q_box">
									<div class="q_ttl">登録日</div>
									<div class="q_con"><?=$edit_insert_date?></div>
									<input type="hidden" name="edit_insert_date" value="<?=$edit_insert_date?>" />
								</div>
								<div class="q_box">
									<div class="q_ttl">最終更新</div>
									<div class="q_con"><?=$edit_update_date?></div>
									<input type="hidden" name="edit_update_date" value="<?=$edit_update_date?>" />
								</div>
								<?}?>
							</div>
							<div class="submit_box">
								<?if($mode=="edit"){?>
								<button type="submit" name="edit_submit" value="edit_submit" class="btn btn-blue">　登　録　</button>
								<?}else{?>
								<button type="submit" name="new_submit" value="new_submit" class="btn btn-blue">　登　録　</button>
								<?}?>
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