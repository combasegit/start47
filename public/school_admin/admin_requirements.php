<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//school_sess.php を取り込む
include_once("./../inc/school_sess.php");
//ページ名
$PAGE_TITLE = "学校情報管理【募集要項･学費】";


if($_REQUEST["edit_submit"]){
	$mode="edit";
	//対象ID
	$edit_school_id = $school_id;//ログイン中のID

	//データ受取
	$edit_contract_rank = $_REQUEST["edit_contract_rank"];
	$edit_password = $_REQUEST["edit_password"];
	$edit_school_name = $_REQUEST["edit_school_name"];
	$edit_insert_date = $_REQUEST["edit_insert_date"];
	$edit_update_date = $_REQUEST["edit_update_date"];


	$edit_admission_number = $_REQUEST["edit_admission_number"];
	$edit_qualification_admission = $_REQUEST["edit_qualification_admission"];
	$edit_admission_period = $_REQUEST["edit_admission_period"];
	$edit_selection_process = $_REQUEST["edit_selection_process"];
	$edit_entrance_fee = $_REQUEST["edit_entrance_fee"];
	$edit_school_fee = $_REQUEST["edit_school_fee"];
	$edit_material_fee = $_REQUEST["edit_material_fee"];
	$edit_facility_fee = $_REQUEST["edit_facility_fee"];
	$edit_sundry_expenses = $_REQUEST["edit_sundry_expenses"];
	$edit_total_fee = $_REQUEST["edit_total_fee"];
	$edit_fee_note = $_REQUEST["edit_fee_note"];
	

	//入力チェック



	//すべての入力項目に誤りが無ければDB登録
	if(!is_array($err)){
		$up_sql = "UPDATE mtb_school SET 
				admission_number = '$edit_admission_number', 
				qualification_admission = '$edit_qualification_admission', 
				admission_period = '$edit_admission_period', 
				selection_process = '$edit_selection_process', 
				entrance_fee = '$edit_entrance_fee', 
				school_fee = '$edit_school_fee', 
				material_fee = '$edit_material_fee', 
				facility_fee = '$edit_facility_fee', 
				sundry_expenses = '$edit_sundry_expenses', 
				total_fee = '$edit_total_fee', 
				fee_note = '$edit_fee_note', 
				update_date = now() 
				WHERE school_id = '$edit_school_id' ";
		if(!( $up_res = $mysqli->query($up_sql))){
			$err0 = 1;
			$errmsg0 = "DBの書き込みに失敗しました。お手数ですが、再度ご入力をお願いします。<br />";
		}else{
			$ok=1;
		}

	}
	
}else{
$mode="edit";
	//対象ID
	$edit_school_id = $school_id;//ログイン中のID
	//既存情報引き出し
	$sql = "select * from mtb_school where school_id = '$edit_school_id' AND del_flag = '0' ";
	$res = $mysqli->query($sql);
	$data = $res->fetch_assoc();
	$edit_contract_rank = $data["contract_rank"];
	$edit_school_name = $data["school_name"];
	$edit_insert_date = $data["insert_date"];
	$edit_update_date = $data["update_date"];
	
	$edit_admission_number = $data["admission_number"];
	$edit_qualification_admission = $data["qualification_admission"];
	$edit_admission_period = $data["admission_period"];
	$edit_selection_process = $data["selection_process"];
	$edit_entrance_fee = $data["entrance_fee"];
	$edit_school_fee = $data["school_fee"];
	$edit_material_fee = $data["material_fee"];
	$edit_facility_fee = $data["facility_fee"];
	$edit_sundry_expenses = $data["sundry_expenses"];
	$edit_total_fee = $data["total_fee"];
	$edit_fee_note = $data["fee_note"];
	
	
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
<?
	if($err_img==1){
?>
						<div class="mid red">
							<?=$errmsg_img?>
						</div>
<?
	}
?>
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
<?
//admin_tab_menu を取り込む
include_once("./00_admin_tab_menu.php");
?>
					<div class="contents_box">
						<form class="form-search" action="" method="post" enctype="multipart/form-data">
							<h2><?=$PAGE_TITLE?>編集</h2>
							<div class="con">
								<div class="q_box">
									<div class="q_ttl">学校ID</div>
									<div class="q_con">
										<?=$edit_school_id?><input type="hidden" name="edit_school_id" value="<?=$edit_school_id?>" />
										<!--
										<a href="/school/<?=$edit_school_id?>/requirements.html?prev=1" target="_blank" class="btn-prev btn">募集要項ﾌﾟﾚﾋﾞｭｰ</a>
										<a href="/school/<?=$edit_school_id?>/fee.html?prev=1" target="_blank" class="btn-prev btn">学費ﾌﾟﾚﾋﾞｭｰ</a>
										-->
										<a href="/school/<?=$edit_school_id?>/requirements.html" target="_blank" class="btn-prev btn">募集要項確認</a>
										<a href="/school/<?=$edit_school_id?>/fee.html" target="_blank" class="btn-prev btn">学費確認</a>
									</div>
								</div>
								<div class="q_box">
									<div class="q_ttl">学校名</div>
									<div class="q_con"><?=$edit_school_name?><input type="hidden" name="edit_school_name" value="<?=$edit_school_name?>" /></div>
								</div>
								<div style="width:50%;float:left;">
									<div class="sub_ttl">募集要項</div>
									<div class="q_box">
										<div class="q_ttl">募集人員</div>
										<div class="q_con"><input type="text" name="edit_admission_number" value="<?=$edit_admission_number?>" /></div>
									</div>
									<div class="q_box">
										<div class="q_ttl">受験資格</div>
										<div class="q_con"><textarea name="edit_qualification_admission" style="width:300px;height:120px;"><?=$edit_qualification_admission?></textarea></div>
									</div>
									<div class="q_box">
										<div class="q_ttl">出願期間</div>
										<div class="q_con"><textarea name="edit_admission_period" style="width:300px;height:120px;"><?=$edit_admission_period?></textarea></div>
									</div>
									<div class="q_box">
										<div class="q_ttl">選考方法</div>
										<div class="q_con"><textarea name="edit_selection_process" style="width:300px;height:120px;"><?=$edit_selection_process?></textarea></div>
									</div>
								</div>
								<div style="width:38%;float:left;margin-left:5px;">
									<div class="sub_ttl">学費</div>
									<div class="q_box">
										<div class="q_ttl"></div>
										<div class="q_con">
											<table class="fee_lst">
												<tr>
													<th style="width:100px;">項目</th>
													<th style="width:320px;">金額</th>
												</tr>
												<tr>
													<th>入学金</th>
													<td><input type="text" name="edit_entrance_fee" value="<?=$edit_entrance_fee?>" /></td>
												</tr>
												<tr>
													<th>授業料</th>
													<td><input type="text" name="edit_school_fee" value="<?=$edit_school_fee?>" /></td>
												</tr>
												<tr>
													<th>教材費</th>
													<td><input type="text" name="edit_material_fee" value="<?=$edit_material_fee?>" /></td>
												</tr>
												<tr>
													<th>施設費</th>
													<td><input type="text" name="edit_facility_fee" value="<?=$edit_facility_fee?>" /></td>
												</tr>
												<tr>
													<th>諸経費</th>
													<td><input type="text" name="edit_sundry_expenses" value="<?=$edit_sundry_expenses?>" /></td>
												</tr>
												<tr>
													<th>合計</th>
													<td><input type="text" name="edit_total_fee" value="<?=$edit_total_fee?>" /></td>
												</tr>
												<tr>
													<th>備考</th>
													<td><textarea name="edit_fee_note" style="width:250px;height:120px;"><?=$edit_fee_note?></textarea></td>
												</tr>
											</table>
										</div>
									</div>
								</div>

								<div class="q_box" style="clear:both;">
									<div class="q_ttl">データ登録日</div>
									<div class="q_con"><?=$edit_insert_date?><input type="hidden" name="edit_insert_date" value="<?=$edit_insert_date?>" /></div>
								</div>
								<div class="q_box">
									<div class="q_ttl">データ最終更新日</div>
									<div class="q_con"><?=$edit_update_date?><input type="hidden" name="edit_update_date" value="<?=$edit_update_date?>" /></div>
								</div>
							</div>
							<div class="submit_box">
								<button type="submit" name="edit_submit" value="edit_submit" class="btn btn-blue">　編　集　</button>
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