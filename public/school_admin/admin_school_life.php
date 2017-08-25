<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//school_sess.php を取り込む
include_once("./../inc/school_sess.php");
//ページ名
$PAGE_TITLE = "学校情報管理【スクールライフ】";


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