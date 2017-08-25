<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//admin_sess.php を取り込む
include_once("./../inc/admin_sess.php");
//ページ名
$PAGE_TITLE = "コンテンツ管理【フィーチャー校指定】";
//キャンパス最大登録数
$max_fs_cnt=20;

//学校一覧を配列に格納
$sql = "SELECT school_id, school_name, contract_rank FROM mtb_school WHERE del_flag = '0' AND contract_rank <= '5' order by contract_rank ";
$res = $mysqli->query($sql);
while($data = $res->fetch_assoc()){
	$school_lst[$data['school_id']]=$data['school_name']."(".$CONTRACT_RANK_ARY[$data['contract_rank']].")";
}

if($_REQUEST["edit_submit"]){
	//データ受取
	$edit_school_id = $_REQUEST["edit_school_id"];
#print_r($edit_school_id);
	//入力チェック
	foreach($edit_school_id as $k=>$val){
		if(strlen($val)){
			if(array_count_values($edit_school_id)[$val]>1){
			 	 $err[edit_school_id][$k] = 1;
			 	 $errmsg[edit_school_id][$k] = "重複指定になっています！";
			}
		}
	}


	//すべての入力項目に誤りが無ければDB登録
	if(!is_array($err)){
		//既存の対象IDでのマッピングを全部削除
		$del_sql = "DELETE FROM dtb_feature_school ";
		$del_res = $mysqli->query($del_sql);#echo $del_sql;

		//DB登録
		if(is_array($edit_school_id)){
			foreach($edit_school_id as $val){
				if(strlen($val)){
					$up2_sql = "INSERT INTO dtb_feature_school (school_id) VALUES ('$val') ";
					$up2_res = $mysqli->query($up2_sql);
				}
			}
		}

		$ok=1;
	}
	
}else{
	$sql = "SELECT school_id FROM dtb_feature_school ";
	$res = $mysqli->query($sql);
	$i=0;
	while($data = $res->fetch_assoc()){$i++;
		$edit_school_id[$i]=$data['school_id'];
	}
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<?
//メタ情報 を取り込む
include_once("./00_meta.php");
?>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/redmond/jquery-ui.css">
<script type="text/javascript" language="javascript">
$(function() {
  $("#datepicker").datepicker();
  $("#datepicker").datepicker("option", "showOn", 'button');
  $("#datepicker").datepicker("option", "buttonImageOnly", true);
  $("#datepicker").datepicker("option", "buttonImage", 'img/ico_calendar.png');
  $("#datepicker2").datepicker();
  $("#datepicker2").datepicker("option", "showOn", 'button');
  $("#datepicker2").datepicker("option", "buttonImageOnly", true);
  $("#datepicker2").datepicker("option", "buttonImage", 'img/ico_calendar.png');
});

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
if($ok==1){
?>
					<!-- 完了画面 -->
					<div class="complete_box">
						<div class="top">登録が完了しました。</div>
						<div class="mid">
							<a href="<?=basename($_SERVER['PHP_SELF'])?>">設定画面へ戻る</a>
						</div>
					</div>
					<!-- //完了画面 -->
<?
}else{
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
							<h2><?=$PAGE_TITLE?>設定</h2>
							<div class="con">
							<?for($i=1;$i<=$max_fs_cnt;$i++){?>
								<div class="q_box">
									<div class="q_ttl<?if($err[edit_school_id][$i]==1){echo " err_bg";}?>">【<?=$i?>】</div>
									<div class="q_con<?if($err[edit_school_id][$i]==1){echo " err_bg";}?>">
										<select name="edit_school_id[<?=$i?>]">
												<option value=""<?if($edit_school_id[$i]==''){echo " selected";}?>>選択</option>
											<?foreach($school_lst AS $k=>$tmp){?>
												<option value="<?=$k?>"<?if($edit_school_id[$i]==$k){echo " selected";}?>><?=$tmp?></option>
											<?}?>
										</select>
										<?if($err[edit_school_id][$i]==1){echo "<span class=\"esg\">※".$errmsg[edit_school_id][$i]."</span>";}?>
									</div>
								</div>
							<?}?>
							</div>
							<div class="submit_box">
								<button type="submit" name="edit_submit" value="edit_submit" class="btn btn-blue">　設　定　</button>
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