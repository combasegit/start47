<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//admin_sess.php を取り込む
include_once("./../inc/admin_sess.php");
//ページ名
$PAGE_TITLE = "学校情報管理【募集要項･学費】";


if($_REQUEST["search"]){
$mode="search";
	//検索条件取得
	$_SESSION["key_name"] = $_REQUEST["key_name"];
	$_SESSION["key_contract_rank"] = $_REQUEST["key_contract_rank"];
	$_SESSION["key_school_type"] = $_REQUEST["key_school_type"];
	$_SESSION["key_establish_type"] = $_REQUEST["key_establish_type"];
	$_SESSION["key_area_id"] = $_REQUEST["key_area_id"];
	$_SESSION["key_pref"] = $_REQUEST["key_pref"];
	
	$k_sql = "SELECT s.* FROM mtb_school AS s ";
	if(strlen($_SESSION["key_pref"])||strlen($_SESSION["key_area_id"])){
		$k_sql .= ",mtb_campus AS c ";
	}
	$k_sql .= "WHERE s.del_flag = '0' ";
	if(strlen($_SESSION["key_pref"])||strlen($_SESSION["key_area_id"])){
		#$k_sql .= "AND s.school_id = c.school_id ";
		$k_sql .= "AND s.school_id = c.school_id AND c.campus_num = '1' ";//20170727追加
	}
	if(strlen($_SESSION["key_area_id"])){
		$k_sql .= "AND c.area_id = '".$_SESSION["key_area_id"]."' ";
	}
	if(strlen($_SESSION["key_pref"])){
		$k_sql .= "AND c.pref = '".$_SESSION["key_pref"]."' ";
	}
	if(strlen($_SESSION["key_name"])){
		$k_sql .= "AND s.school_name like '%".$_SESSION["key_name"]."%' ";
	}
	if(strlen($_SESSION["key_contract_rank"])){
		$k_sql .= "AND s.contract_rank = '".$_SESSION["key_contract_rank"]."' ";
	}
	if(strlen($_SESSION["key_school_type"])){
		$k_sql .= "AND s.school_type = '".$_SESSION["key_school_type"]."' ";
	}
	if(strlen($_SESSION["key_establish_type"])){
		$k_sql .= "AND s.establish_type = '".$_SESSION["key_establish_type"]."' ";
	}
	$k_sql .= "ORDER BY s.insert_date DESC ";
	$k_res = $mysqli->query($k_sql);
	$k_cnt = $k_res->num_rows;

}elseif($_REQUEST["edit_submit"]){
	$mode="edit";
	//対象ID
	$edit_school_id = $_REQUEST["edit_school_id"];

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
	
}elseif($_REQUEST["edit"]){
$mode="edit";
	//対象ID
	$edit_school_id = $_REQUEST["edit"];
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
if($mode!="edit"&&$mode!="new"){
?>
					<div class="contents_box">
						<form class="form-search" action="" method="post">
							<h2>登録済みデータ検索</h2>
							<div class="con">
								<div class="q_box">
									<div class="q_ttl">掲載</div>
									<div class="q_con">
										<label><input type="radio" name="key_contract_rank" value="" <?if($_SESSION["key_contract_rank"]==""){echo "checked";}?>/>すべて</label>　　
										<?foreach($CONTRACT_RANK_ARY as $k=>$val){?>
										<label><input type="radio" name="key_contract_rank" value="<?=$k?>" <?if($_SESSION["key_contract_rank"]==$k){echo "checked";}?>/><?=$val?></label>　　
										<?}?>
									</div>
								</div>
								<div class="q_box">
									<div class="q_ttl">学校種別</div>
									<div class="q_con">
										<label><input type="radio" name="key_school_type" value="" <?if($_SESSION["key_school_type"]==""){echo "checked";}?>/>すべて</label>　　
										<?foreach($SCHOOL_TYPE_ARY as $k=>$val){?>
										<label><input type="radio" name="key_school_type" value="<?=$k?>" <?if($_SESSION["key_school_type"]==$k){echo "checked";}?>/><?=$val?></label>　　
										<?}?>
									</div>
								</div>
								<div class="q_box">
									<div class="q_ttl">設立種別</div>
									<div class="q_con">
										<label><input type="radio" name="key_establish_type" value="" <?if($_SESSION["key_establish_type"]==""){echo "checked";}?>/>すべて</label>　　
										<?foreach($ESTABLISH_TYPE_ARY as $k=>$val){?>
										<label><input type="radio" name="key_establish_type" value="<?=$k?>" <?if($_SESSION["key_establish_type"]==$k){echo "checked";}?>/><?=$val?></label>　　
										<?}?>
									</div>
								</div>
								<div class="q_box">
									<div class="q_ttl">キャンパス地域</div>
									<div class="q_con">
										<select name="key_area_id" id="key_area_id">
											<option value="">選択</option>
											<?foreach($AREA as $k=>$val){?>
											<option value="<?=$k?>"<?if($_SESSION["key_area_id"]==$k){echo " selected";}?>><?=$val?></option>
											<?}?>
										</select>
									</div>
								</div>
								<div class="q_box">
									<div class="q_ttl">キャンパス都道府県</div>
									<div class="q_con">
										<select name="key_pref">
											<option value="">選択</option>
											<?foreach($PREFECTURE AS $p=>$val){?>
											<option value="<?=$p?>"<?if($_SESSION["key_pref"]==$p){echo " selected";}?>><?=$val?></option>
											<?}?>
										</select>
									</div>
								</div>
								<div class="q_box">
									<div class="q_ttl">キーワード</div>
									<div class="q_con"><input type="text" name="key_name" value="<?=$_SESSION["key_name"]?>" /></div>
								</div>
							</div>
							<div class="submit_box">
								<button type="submit" name="search" value="1" class="btn btn-blue">　検　索　</button>
							</div>
						</form>
					</div><!--/contents_box-->
<?
}
?>
<?
if($mode=="search"){
?>
					<div class="contents_box">
						<h2>検索結果　　<?=$k_cnt?>件Hitしました。</h2>
						<div class="con">
							<table>
								<thead>
									<tr>
										<th>ID</th>
										<th>掲載</th>
										<th>学校種</th>
										<th>設立種</th>
										<th>学校名</th>
										<th>登録日</th>
										<th>ｷｬﾝﾊﾟｽ数</th>
										<th>編集</th>
									</tr>
								</thead>
								<tbody>
<?
while($k_data = $k_res->fetch_assoc()){
	//キャンパス情報引き出し
	$c_sql = "SELECT * FROM mtb_campus WHERE school_id = '".$k_data["school_id"]."' ";
	$c_res = $mysqli->query($c_sql);
	$c_cnt = $c_res->num_rows;
?>
									<tr>
										<td><?=$k_data["school_id"]?></td>
										<td><?=$CONTRACT_RANK_ARY[$k_data["contract_rank"]]?></td>
										<td><?=$SCHOOL_TYPE_ARY[$k_data["school_type"]]?></td>
										<td><?=$ESTABLISH_TYPE_ARY[$k_data["establish_type"]]?></td>
										<td><?=$k_data["school_name"]?></td>
										<td><?=$k_data["insert_date"]?></td>
										<td style="text-align:center;"><?=$c_cnt?></td>
										<td style="text-align:center;">
											<form action="" method="post">
												<button type="submit" name="edit" value="<?=$k_data["school_id"]?>" class="btn btn-blue">編集</button>
											</form>
										</td>
									</tr>
<?
}
?>
								</tbody>
							</table>
						</div>
						<br style="clear:left;" />
					</div><!--/contents_box-->
<?
}elseif($ok==1){
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
							<a href="<?=basename($_SERVER['PHP_SELF'])?>">検索画面へ戻る</a>
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
					<?if($mode=="edit"){?>
<?
//admin_tab_menu を取り込む
include_once("./00_admin_tab_menu.php");
?>
					<?}?>
					<div class="contents_box">
						<form class="form-search" action="" method="post" enctype="multipart/form-data">
							<h2><?=$PAGE_TITLE?><?if($mode=="edit"){?>編集<?}else{?>新規登録<?}?></h2>
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
									<div class="q_ttl">掲載</div>
									<div class="q_con">
										<?=$CONTRACT_RANK_ARY[$edit_contract_rank]?>
										<input type="hidden" name="edit_contract_rank" value="<?=$edit_contract_rank?>" />
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