<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//admin_sess.php を取り込む
include_once("./../inc/admin_sess.php");
//ページ名
$PAGE_TITLE = "コンテンツ管理【お知らせ】";

//学校一覧を配列に格納
$sql = "SELECT school_id, school_name FROM mtb_school WHERE del_flag = '0' order by contract_rank ";
$res = $mysqli->query($sql);
while($data = $res->fetch_assoc()){
	$school_lst[$data['school_id']]=$data['school_name'];
}

$_SESSION["key_s_date"] = date("Y/m/d", strtotime("-30 day"));//30日前
$_SESSION["key_e_date"] = date("Y/m/d", strtotime("+5 day"));//５日後


if($_REQUEST["search"]||$_REQUEST["del"]){
$mode="search";
	if($_REQUEST["del"]){
		//削除対象ID
		$del_id = $_REQUEST["del"];
		//del_flag立てる
		$del_sql = "UPDATE dtb_school_news SET del_flag = '1' WHERE news_id = '$del_id' ";
		if(!($del_res = $mysqli->query($del_sql))){
			$del_err = 1;#echo $ed_sql;
			$del_errmsg = "削除に失敗しました。お手数ですが、再度ご入力をお願いします。<br />";
		}else{
		 	 $ok=1;
		}
	}

	//検索条件取得
	$_SESSION["key_s_date"] = $_REQUEST["key_s_date"];
	$_SESSION["key_e_date"] = $_REQUEST["key_e_date"];
	$_SESSION["key_word"] = $_REQUEST["key_word"];
	$_SESSION["key_school_id"] = $_REQUEST["key_school_id"];
	
	$k_sql = "select *, date_format(news_date, '%Y/%m/%d') AS news_date2 FROM dtb_school_news WHERE del_flag = '0' AND news_date BETWEEN '".$_SESSION["key_s_date"]." 00:00:01' AND '".$_SESSION["key_e_date"]." 23:59:59' ";
	if(strlen($_SESSION["key_school_id"])){
		$k_sql .= "AND school_id = ".$_SESSION["key_school_id"]." ";
	}
	if(strlen($_SESSION["key_word"])){
		$k_sql .= "AND ((news_title like '%".$_SESSION["key_word"]."%') OR (news_text like '%".$_SESSION["key_word"]."%') ";
	}
	$k_sql .= "ORDER BY news_date DESC";
	$k_res = $mysqli->query($k_sql);
	$k_cnt = $k_res->num_rows;

}elseif($_REQUEST["new_submit"]||$_REQUEST["edit_submit"]){
	if($_REQUEST["edit_submit"]){
		$mode="edit";
		$news_id=$_REQUEST["news_id"];
	}else{
		$mode="new";
	}
	//データ受取
	$edit_school_id = $_REQUEST["edit_school_id"];
	$edit_news_date = $_REQUEST["edit_news_date"];
	$edit_news_title = $_REQUEST["edit_news_title"];
	$edit_news_text = $_REQUEST["edit_news_text"];
	$edit_insert_date = $_REQUEST["edit_insert_date"];
	$edit_update_date = $_REQUEST["edit_update_date"];

	//入力チェック
	//必須
	 $ary = array(array("empty"));
	 $chk = new CheckError($edit_school_id, "投稿学校", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_school_id] = 1;
	 	 $errmsg[edit_school_id] = $chk->checkErrorAll();
	 }
	 $chk = new CheckError($edit_news_date, "表示日", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_news_date] = 1;
	 	 $errmsg[edit_news_date] = $chk->checkErrorAll();
	 }
	//必須・全角20文字以内
	 $ary = array(array("empty"),array("NGchar"),
				 array("maxZen", 30));
	 $chk = new CheckError($edit_news_title, "タイトル", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_news_title] = 1;
	 	 $errmsg[edit_news_title] = $chk->checkErrorAll();
	 }
	//必須
	 $ary = array(array("empty"));
	 $chk = new CheckError($edit_news_text, "内容", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_news_text] = 1;
	 	 $errmsg[edit_news_text] = $chk->checkErrorAll();
	 }



	//すべての入力項目に誤りが無ければDB登録
	if(!is_array($err)){
		if($mode=="new"){
			$up_sql = "INSERT INTO dtb_school_news (school_id, news_date, news_title, news_text, insert_date)
								 VALUES ('$edit_school_id','$edit_news_date','$edit_news_title','$edit_news_text',now()) ";
		}else{
			$up_sql = "UPDATE dtb_school_news SET 
					school_id = '$edit_school_id', 
					news_date = '$edit_news_date', 
					news_title = '$edit_news_title', 
					news_text = '$edit_news_text', 
					update_date = now() 
					WHERE news_id = '$news_id' ";
		}
		if(!($up_res = $mysqli->query($up_sql))){
			$err0 = 1;
			$errmsg0 = "DBの書き込みに失敗しました。お手数ですが、再度ご入力をお願いします。<br />";
		}else{
			$ok=1;
		}
	}
	
}elseif($_REQUEST["edit"]){
$mode="edit";
	//対象ID
	$news_id = $_REQUEST["edit"];
	//既存情報引き出し
	$sql = "select * from dtb_school_news where news_id = '$news_id' ";
	$res = $mysqli->query($sql);
	$data = $res->fetch_assoc();
	$edit_news_date = $data["news_date"];
	$edit_news_date = str_replace('-','/',$edit_news_date);
	
	$edit_school_id = $data["school_id"];
	$edit_news_title = $data["news_title"];
	$edit_news_text = $data["news_text"];
	$edit_insert_date = $data["insert_date"];
	$edit_update_date = $data["update_date"];
	
}elseif($_REQUEST["new"]){
	$mode="new";
	$edit_news_date =date("Y/m/d");
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
});

$(function() {
  $("#datepicker").datepicker();
  $("#datepicker").datepicker("option", "showOn", 'button');
  $("#datepicker").datepicker("option", "buttonImageOnly", true);
  $("#datepicker").datepicker("option", "buttonImage", 'img/ico_calendar.png');
  $("#datepicker2").datepicker();
  $("#datepicker2").datepicker("option", "showOn", 'button');
  $("#datepicker2").datepicker("option", "buttonImageOnly", true);
  $("#datepicker2").datepicker("option", "buttonImage", 'img/ico_calendar.png');
  $("#datepicker3").datepicker();
  $("#datepicker3").datepicker("option", "showOn", 'button');
  $("#datepicker3").datepicker("option", "buttonImageOnly", true);
  $("#datepicker3").datepicker("option", "buttonImage", 'img/ico_calendar.png');
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
if($mode!="edit"&&$mode!="new"){
?>
					<div class="add_btn_box">
						<form class="form-new" action="" method="post">
							<button type="submit" name="new" value="1" class="btn btn-green">　新規登録　</button>
						</form>
					</div>
					<div class="contents_box">
						<form class="form-search" action="" method="post">
							<h2>登録済みお知らせ検索</h2>
							<div class="con">
								<div class="q_box">
									<div class="q_ttl">表示日</div>
									<div class="q_con">
										<input type="text" name="key_s_date" value="<?=$_SESSION["key_s_date"]?>" id="datepicker">　～　
										<input type="text" name="key_e_date" value="<?=$_SESSION["key_e_date"]?>" id="datepicker2">
									</div>
								</div>
								<div class="q_box">
									<div class="q_ttl">キーワード</div>
									<div class="q_con"><input type="text" name="key_word" value="<?=$_SESSION["key_word"]?>" /></div>
								</div>
								<div class="q_box">
									<div class="q_ttl">投稿学校</div>
									<div class="q_con">
										<select name="key_school_id">
												<option value=""<?if($_SESSION["key_school_id"]==''){echo " selected";}?>>すべて</option>
											<?foreach($school_lst AS $k=>$tmp){?>
												<option value="<?=$k?>"<?if($_SESSION["key_school_id"]=='$k'){echo " selected";}?>><?=$tmp?></option>
											<?}?>
										</select>
									</div>
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
					<?if($ok==1){?><p style="color:#0000ff;">削除に成功しました。</p><?}?>
					<?if($del_err==1){?><p style="color:#ff0000;"><?=$del_errmsg?></p><?}?>
					<div class="contents_box">
						<h2>検索結果</h2>
						<div class="con">
							<table>
								<thead>
									<tr>
										<th>No.</th>
										<th>学校</th>
										<th>表示日</th>
										<th>タイトル</th>
										<th>登録日</th>
										<th>編集</th>
									</tr>
								</thead>
								<tbody>
<?
while($k_data = $k_res->fetch_assoc()){$i++;
?>
									<tr>
										<td class="center"><?=$i?></td>
										<td><?=$school_lst[$k_data["school_id"]]?></td>
										<td><?=$k_data["news_date"]?></td>
										<td class="center"><?=$k_data["news_title"]?></td>
										<td><?=$k_data["insert_date"]?></td>
										<td class="center">
											<form action="" method="post">
												<button type="submit" name="edit" value="<?=$k_data["news_id"]?>" class="btn btn-blue">編集</button>
												<button type="submit" name="del" value="<?=$k_data["news_id"]?>" class="btn btn-red" onclick="return confirm('本当に削除しますか？')">削除</button>
											</form>
										</td>
									</tr>
<?
}
?>
								</tbody>
							</table>
						</div>
					</div><!--/contents_box-->
<?
}elseif($ok==1){
?>
					<!-- 完了画面 -->
					<div class="complete_box">
						<div class="top">登録が完了しました。</div>
						<div class="mid">
							<a href="<?=basename($_SERVER['PHP_SELF'])?>">検索画面へ戻る</a>
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
								<div class="q_box">
									<div class="q_ttl<?if($err[edit_school_id]==1){echo " err_bg";}?>">投稿学校</div>
									<div class="q_con<?if($err[edit_school_id]==1){echo " err_bg";}?>">
										<select name="edit_school_id">
												<option value=""<?if($edit_school_id==''){echo " selected";}?>>選択</option>
											<?foreach($school_lst AS $k=>$tmp){?>
												<option value="<?=$k?>"<?if($edit_school_id=='$k'){echo " selected";}?>><?=$tmp?></option>
											<?}?>
										</select>
										<?if($err[edit_school_id]==1){echo "<span class=\"esg\">※".$errmsg[edit_school_id]."</span>";}?>
									</div>
								</div>
								<div class="q_box">
									<div class="q_ttl<?if($err[edit_news_date]==1){echo " err_bg";}?>">表示日</div>
									<div class="q_con"><input type="text" name="edit_news_date" value="<?=$edit_news_date?>" id="datepicker3"><?if($err[edit_news_date]==1){echo "<span class=\"esg\">※".$errmsg[edit_news_date]."</span>";}?></div>
								</div>
								<div class="q_box<?if($err[edit_news_title]==1){echo " err_bg";}?>">
									<div class="q_ttl">タイトル</div>
									<div class="q_con"><input type="text" name="edit_news_title" value="<?=$edit_news_title?>" style="width:300px;" /><?if($err[edit_news_title]==1){echo "<span class=\"esg\">※".$errmsg[edit_news_title]."</span>";}?></div>
								</div>
								<div class="q_box<?if($err[edit_news_text]==1){echo " err_bg clearfix";}?>">
									<div class="q_ttl">内容</div>
									<div class="q_con">
										<textarea cols="80" id="edit_news_text" name="edit_news_text" rows="10"><?=$edit_news_text?></textarea><?if($err[edit_news_text]==1){echo "<span class=\"esg\">※".$errmsg[edit_news_text]."</span>";}?>
									</div>
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
								<input type="hidden" name="news_id" value="<?=$news_id?>" />
								<button type="submit" name="edit_submit" value="edit_submit" class="btn btn-blue">　編　集　</button>
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