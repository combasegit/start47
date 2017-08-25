<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//admin_sess.php を取り込む
include_once("./../inc/admin_sess.php");
//ページ名
$PAGE_TITLE = "学校情報管理【イベント情報】";

//学校一覧を配列に格納
$sql = "SELECT school_id, school_name FROM mtb_school WHERE del_flag = '0' order by contract_rank ";
$res = $mysqli->query($sql);
while($data = $res->fetch_assoc()){
	$school_lst[$data['school_id']]=$data['school_name'];
}

$_SESSION["key_s_date"] = date("Y/m/d", strtotime("-30 day"));//30日前
$_SESSION["key_e_date"] = date("Y/m/d", strtotime("+5 day"));//５日後
$_SESSION["key_all_day"] =1;


if($_REQUEST["search"]||$_REQUEST["del"]){
$mode="search";
	if($_REQUEST["del"]){
		//削除対象ID
		$del_id = $_REQUEST["del"];
		//del_flag立てる
		$del_sql = "UPDATE mtb_school_event SET del_flag = '1' WHERE event_id = '$del_id' ";
		if(!($del_res = $mysqli->query($del_sql))){
			$del_err = 1;
			$del_errmsg = "削除に失敗しました。お手数ですが、再度ご入力をお願いします。<br />";
		}else{
		 	 $ok=1;
		}
	}

	//検索条件取得
	$_SESSION["key_all_day"] = $_REQUEST["key_all_day"];
	$_SESSION["key_s_date"] = $_REQUEST["key_s_date"];
	$_SESSION["key_e_date"] = $_REQUEST["key_e_date"];
	$_SESSION["key_word"] = $_REQUEST["key_word"];
	$_SESSION["key_school_id"] = $_REQUEST["key_school_id"];
	
	$k_sql = "select DISTINCT m.* FROM mtb_school_event AS m ";
	if(($_SESSION["key_all_day"]!='1')&&strlen($_SESSION["key_s_date"])&&strlen($_SESSION["key_e_date"])){
		$k_sql .= ", dtb_event_date AS d ";
	}
	$k_sql .= "WHERE m.del_flag = '0' ";
	if(($_SESSION["key_all_day"]!='1')&&strlen($_SESSION["key_s_date"])&&strlen($_SESSION["key_e_date"])){
		$k_sql .= "AND m.event_id = d.event_id AND d.event_date BETWEEN '".$_SESSION["key_s_date"]."' AND '".$_SESSION["key_e_date"]."' ";
	}
	if(strlen($_SESSION["key_school_id"])){
		$k_sql .= "AND m.school_id = ".$_SESSION["key_school_id"]." ";
	}
	if(strlen($_SESSION["key_word"])){
		$k_sql .= "AND ((m.event_title like '%".$_SESSION["key_word"]."%') OR (m.event_text like '%".$_SESSION["key_word"]."%') ";
	}
	$k_res = $mysqli->query($k_sql);
	$k_cnt = $k_res->num_rows;

}elseif($_REQUEST["new_submit"]||$_REQUEST["edit_submit"]){
	if($_REQUEST["edit_submit"]){
		$mode="edit";
		$event_id=$_REQUEST["event_id"];
		//データ受取
		$event_days = $_REQUEST["event_days"];
		$tg_y = $_REQUEST["tg_y"];//一旦削除するための対象年度
	}else{
		$mode="new";
	}
	//データ受取
	$edit_school_id = $_REQUEST["edit_school_id"];
	$edit_event_title = $_REQUEST["edit_event_title"];
	$edit_event_text = $_REQUEST["edit_event_text"];
	$edit_insert_date = $_REQUEST["edit_insert_date"];
	$edit_update_date = $_REQUEST["edit_update_date"];

	//入力チェック
	//必須・全角20文字以内
	 $ary = array(array("empty"),array("NGchar"),
				 array("maxZen", 30));
	 $chk = new CheckError($edit_event_title, "タイトル", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_event_title] = 1;
	 	 $errmsg[edit_event_title] = $chk->checkErrorAll();
	 }
	//必須
	 $ary = array(array("empty"));
	 $chk = new CheckError($edit_school_id, "投稿学校", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_school_id] = 1;
	 	 $errmsg[edit_school_id] = $chk->checkErrorAll();
	 }
	 $chk = new CheckError($edit_event_text, "内容", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_event_text] = 1;
	 	 $errmsg[edit_event_text] = $chk->checkErrorAll();
	 }



	//すべての入力項目に誤りが無ければDB登録
	if(!is_array($err)){
		if($mode=="new"){
			$up_sql = "INSERT INTO mtb_school_event (school_id, event_title, event_text, insert_date)
								 VALUES ('$edit_school_id','$edit_event_title','$edit_event_text',now()) ";
		}else{
			$up_sql = "UPDATE mtb_school_event SET 
					school_id = '$edit_school_id', 
					event_title = '$edit_event_title', 
					event_text = '$edit_event_text', 
					update_date = now() 
					WHERE event_id = '$event_id' ";
		}
		if(!($up_res = $mysqli->query($up_sql))){
			$err0 = 1;
			$errmsg0 = "DBの書き込みに失敗しました。お手数ですが、再度ご入力をお願いします。<br />";
		}else{
			if($mode=="edit"){
				$del_st = $tg_y."-04-01";
				$del_en = ($tg_y+1)."-03-31";

				//既存の対象IDでのマッピングを全部削除
				$del_sql = "DELETE FROM dtb_event_date where event_id = '$event_id' AND event_date BETWEEN '$del_st' AND '$del_en' ";
				$del_res = $mysqli->query($del_sql);#echo $del_sql;

				//DB登録
				if(is_array($event_days)){
					foreach($event_days as $val){
						$up2_sql = "INSERT INTO dtb_event_date (event_id, event_date, insert_date) VALUES ('$event_id', '$val', now()) ";
						$up2_res = $mysqli->query($up2_sql);
					}
				}
			}

			$ok=1;
		}
	}
	
}elseif($_REQUEST["edit"]){
$mode="edit";
	//対象ID
	$event_id = $_REQUEST["edit"];
	//既存情報引き出し
	$sql = "select * from mtb_school_event where event_id = '$event_id' ";
	$res = $mysqli->query($sql);
	$data = $res->fetch_assoc();
	$edit_event_title = $data["event_title"];
	$edit_event_text = $data["event_text"];
	$edit_insert_date = $data["insert_date"];
	$edit_update_date = $data["update_date"];
	
	//カレンダー作成
	if($_GET['nendo']){
		$tg_y = $_GET['nendo'];
	}else{
		$tg_y = date('Y');
		$tg_m = date('n');
		if($tg_m<4){
			$tg_y = $tg_y-1;
		}
	}
	//登録済み運行日の引き出し
	$EVENT_DAYS_ARY=array();
	$sql = "SELECT *, date_format(event_date, '%Y-%c-%e') AS event_date2 FROM dtb_event_date WHERE event_id = '$event_id' ";
	$res = $mysqli->query($sql);
	while($data = $res->fetch_assoc()){
		$EVENT_DAYS_ARY[] = $data[event_date2];
	}

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

function chebg(chkID){//タグの背景色変更
    Myid=document.getElementById(chkID);
    if(Myid.checked == true){
        Myid.parentNode.style.backgroundColor = '#4AB893';
        Myid.parentNode.style.color = '#FFFFFF';
    }else{
        Myid.parentNode.style.backgroundColor = '#FFFFFF';//背景色
        Myid.parentNode.style.color = '#333333';//文字色
    }
}
function chebg_r(chkID){//タグの背景色変更(日曜日)
    Myid=document.getElementById(chkID);
    if(Myid.checked == true){
        Myid.parentNode.style.backgroundColor = '#4AB893';
        Myid.parentNode.style.color = '#FFFFFF';
    }else{
        Myid.parentNode.style.backgroundColor = '#FFFFFF';//背景色
        Myid.parentNode.style.color = 'red';//文字色
    }
}
function chebg_b(chkID){//タグの背景色変更(土曜日)
    Myid=document.getElementById(chkID);
    if(Myid.checked == true){
        Myid.parentNode.style.backgroundColor = '#4AB893';
        Myid.parentNode.style.color = '#FFFFFF';
    }else{
        Myid.parentNode.style.backgroundColor = '#FFFFFF';//背景色
        Myid.parentNode.style.color = 'blue';//文字色
    }
}

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
							<h2>登録済みイベント検索</h2>
							<div class="con">
								<div class="q_box">
									<div class="q_ttl">開催日</div>
									<div class="q_con">
										<label><input type="checkbox" name="key_all_day" value="1" <?if($_SESSION["key_all_day"]=='1'){echo "checked ";}?>/>全期間</label>　　
										<input type="text" name="key_s_date" value="<?=$_SESSION["key_s_date"]?>" id="datepicker">　～　
										<input type="text" name="key_e_date" value="<?=$_SESSION["key_e_date"]?>" id="datepicker2">←この期間中に1日でも開催があれば表示
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
										<td class="center"><?=$k_data["event_title"]?></td>
										<td><?=$k_data["insert_date"]?></td>
										<td class="center">
											<form action="" method="post">
												<button type="submit" name="edit" value="<?=$k_data["event_id"]?>" class="btn btn-blue">編集</button>
												<button type="submit" name="del" value="<?=$k_data["event_id"]?>" class="btn btn-red" onclick="return confirm('本当に削除しますか？')">削除</button>
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
							<a href="?edit=<?=$event_id?>">開催日程を登録する</a><br />
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
							<div class="con">
								<div class="q_box<?if($err[edit_event_title]==1){echo " err_bg";}?>">
									<div class="q_ttl">タイトル</div>
									<div class="q_con"><input type="text" name="edit_event_title" value="<?=$edit_event_title?>" style="width:300px;" /><?if($err[edit_event_title]==1){echo "<span class=\"esg\">※".$errmsg[edit_event_title]."</span>";}?></div>
								</div>
								<div class="q_box<?if($err[edit_event_text]==1){echo " err_bg clearfix";}?>">
									<div class="q_ttl">内容</div>
									<div class="q_con">
										<textarea cols="80" id="edit_event_text" name="edit_event_text" rows="20"><?=$edit_event_text?></textarea><?if($err[edit_event_text]==1){echo "<span class=\"esg\">※".$errmsg[edit_event_text]."</span>";}?>
									</div>
								</div>
								<?if($mode=="edit"){?>
								<div class="q_box">
									<div class="q_ttl">開催日</div>
									<div class="q_con"><span class="red">※登録は、年度毎になります。タイトル・内容を含む表示年度内で変更がある場合には必ず「編集」を押してください。</span>
										<table class="nendo-navi">
											<tr>
												<td style="text-align:left;"><a href="?edit=<?=$event_id?>&nendo=<?=$tg_y-1?>"><<前年度へ</a></td>
												<th><?=$tg_y?>年度</th>
												<td style="text-align:right;"><a href="?edit=<?=$event_id?>&nendo=<?=$tg_y+1?>">翌年度へ>></a>　</td>
											</tr>
										</table>
										<?
										for($z=0;$z<=11;$z++){
											$y=$tg_y;
											$m=4+$z;
											if($m>12){
												$y=$tg_y+1;
												$m=$m-12;
											}
										?>
										<div class="calendar">
											<table>
												<tr>
													<td colspan="7"><?php echo $y ?>年　<?php echo $m ?>月</td>
												</tr>
												<tr>
													<th>日</th>
													<th>月</th>
													<th>火</th>
													<th>水</th>
													<th>木</th>
													<th>金</th>
													<th>土</th>
												</tr>
												<tr>
											<?
												// 1日の曜日を取得
												$wd1 = date("w", mktime(0, 0, 0, $m, 1, $y));
												// その数だけ空のセルを作成
												for ($i = 1; $i <= $wd1; $i++) {
													echo "<td> </td>";
												}
												$d = 1;
												while (checkdate($m, $d, $y)) {
													//登録確認
													if(in_array($y."-".$m."-".$d,$EVENT_DAYS_ARY)){
														$ckd_style=" style=\"background-color:#4AB893;color:#FFF;\"";
														$ckd=" checked";
													}else{
														$ckd_style="";
														$ckd="";
													}
													// 日曜：赤色
													if(date("w", mktime(0, 0, 0, $m, $d, $y)) == 0)
													{
														echo "<td style='color:red;'><label".$ckd_style."><input class=\"check\" name=\"event_days[]\" type=\"checkbox\" id=\"".$y."-".$m."-".$d."\" onclick=\"chebg_r('".$y."-".$m."-".$d."')\" value=\"".$y."-".$m."-".$d."\"".$ckd.">".$d."</label></td>";
													}
													// 土曜：青色
													elseif(date("w", mktime(0, 0, 0, $m, $d, $y)) == 6)
													{
														echo "<td style='color:blue;'><label".$ckd_style."><input class=\"check\" name=\"event_days[]\" type=\"checkbox\" id=\"".$y."-".$m."-".$d."\" onclick=\"chebg_b('".$y."-".$m."-".$d."')\" value=\"".$y."-".$m."-".$d."\"".$ckd.">".$d."</label></td>";
													}
													// 土日以外
													else
													{
														echo "<td><label".$ckd_style."><input class=\"check\" name=\"event_days[]\" type=\"checkbox\" id=\"".$y."-".$m."-".$d."\" onclick=\"chebg('".$y."-".$m."-".$d."')\" value=\"".$y."-".$m."-".$d."\"".$ckd.">".$d."</label></td>";
													}
													// 週の始まりと終わりでタグを出力
													if (date("w", mktime(0, 0, 0, $m, $d, $y)) == 6)
													{
													    // 週を終了
													    echo "</tr>";
														
														// 次の週がある場合は新たな行を準備
													    if (checkdate($m, $d + 1, $y)) {
													        echo "<tr>";
													    }
													}
												    $d++;
												}
												// 最後の週の土曜日まで空のセルを作成
												$wdx = date("w", mktime(0, 0, 0, $m + 1, 0, $y));
												for ($i = 1; $i < 7 - $wdx; $i++)
												{
													echo "<td>　</td>";
												}
											?>
												</tr>
											</table>
										</div>
										<?}?>
									</div>
								</div>
								<?}else{?>
								<span class="red">※開催日の登録は、イベント内容の登録完了後に行えるようになります。</span>
								<?}?>
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
								<input type="hidden" name="event_id" value="<?=$event_id?>" />
								<input type="hidden" name="tg_y" value="<?=$tg_y?>" />
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