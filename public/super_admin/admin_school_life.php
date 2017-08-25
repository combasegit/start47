<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//admin_sess.php を取り込む
include_once("./../inc/admin_sess.php");
//ページ名
$PAGE_TITLE = "学校情報管理【スクールライフ】";


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


	$edit_schooling_title = $_REQUEST["edit_schooling_title"];
	$edit_schooling_txt = $_REQUEST["edit_schooling_txt"];
	$edit_regulation_title = $_REQUEST["edit_regulation_title"];
	$edit_regulation_txt = $_REQUEST["edit_regulation_txt"];
	$edit_club_title = $_REQUEST["edit_club_title"];
	$edit_club_txt = $_REQUEST["edit_club_txt"];
	$edit_event_title = $_REQUEST["edit_event_title"];
	$edit_event_txt = $_REQUEST["edit_event_txt"];
	

	//入力チェック



	//すべての入力項目に誤りが無ければDB登録
	if(!is_array($err)){
		$up_sql = "UPDATE mtb_school SET 
				schooling_title = '$edit_schooling_title', 
				schooling_txt = '$edit_schooling_txt', 
				regulation_title = '$edit_regulation_title', 
				regulation_txt = '$edit_regulation_txt', 
				club_title = '$edit_club_title', 
				club_txt = '$edit_club_txt', 
				event_title = '$edit_event_title', 
				event_txt = '$edit_event_txt', 
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
	
	$edit_schooling_title = $data["schooling_title"];
	$edit_schooling_txt = $data["schooling_txt"];
	$edit_regulation_title = $data["regulation_title"];
	$edit_regulation_txt = $data["regulation_txt"];
	$edit_club_title = $data["club_title"];
	$edit_club_txt = $data["club_txt"];
	$edit_event_title = $data["event_title"];
	$edit_event_txt = $data["event_txt"];
	
	
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
										<a href="/school/<?=$edit_school_id?>/schooling.html?prev=1" target="_blank" class="btn-prev btn">スクーリングﾌﾟﾚﾋﾞｭｰ</a>
										<a href="/school/<?=$edit_school_id?>/regulation.html?prev=1" target="_blank" class="btn-prev btn">服装・規定ﾌﾟﾚﾋﾞｭｰ</a>
										<a href="/school/<?=$edit_school_id?>/club.html?prev=1" target="_blank" class="btn-prev btn">クラブ活動ﾌﾟﾚﾋﾞｭｰ</a>
										<a href="/school/<?=$edit_school_id?>/event.html?prev=1" target="_blank" class="btn-prev btn">イベント・行事ﾌﾟﾚﾋﾞｭｰ</a>
										-->
										<a href="/school/<?=$edit_school_id?>/schooling.html" target="_blank" class="btn-prev btn">スクーリング確認</a>
										<a href="/school/<?=$edit_school_id?>/regulation.html" target="_blank" class="btn-prev btn">服装・規定確認</a>
										<a href="/school/<?=$edit_school_id?>/club.html" target="_blank" class="btn-prev btn">クラブ活動確認</a>
										<a href="/school/<?=$edit_school_id?>/event.html" target="_blank" class="btn-prev btn">イベント・行事確認</a>
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
								<div class="sub_ttl">スクーリング</div>
								<div class="q_box">
									<div class="q_ttl">見出し</div>
									<div class="q_con"><input type="text" name="edit_schooling_title" value="<?=$edit_schooling_title?>" style="width:600px;"/></div>
								</div>
								<div class="q_box">
									<div class="q_ttl">本文</div>
									<div class="q_con"><textarea name="edit_schooling_txt" style="width:600px;height:250px;"><?=$edit_schooling_txt?></textarea></div>
								</div>
								<div class="sub_ttl">服装・規定</div>
								<div class="q_box">
									<div class="q_ttl">見出し</div>
									<div class="q_con"><input type="text" name="edit_regulation_title" value="<?=$edit_regulation_title?>" style="width:600px;"/></div>
								</div>
								<div class="q_box">
									<div class="q_ttl">本文</div>
									<div class="q_con"><textarea name="edit_regulation_txt" style="width:600px;height:250px;"><?=$edit_regulation_txt?></textarea></div>
								</div>
								<div class="sub_ttl">クラブ活動</div>
								<div class="q_box">
									<div class="q_ttl">見出し</div>
									<div class="q_con"><input type="text" name="edit_club_title" value="<?=$edit_club_title?>" style="width:600px;"/></div>
								</div>
								<div class="q_box">
									<div class="q_ttl">本文</div>
									<div class="q_con"><textarea name="edit_club_txt" style="width:600px;height:250px;"><?=$edit_club_txt?></textarea></div>
								</div>
								<div class="sub_ttl">イベント・行事</div>
								<div class="q_box">
									<div class="q_ttl">見出し</div>
									<div class="q_con"><input type="text" name="edit_event_title" value="<?=$edit_event_title?>" style="width:600px;"/></div>
								</div>
								<div class="q_box">
									<div class="q_ttl">本文</div>
									<div class="q_con"><textarea name="edit_event_txt" style="width:600px;height:250px;"><?=$edit_event_txt?></textarea></div>
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