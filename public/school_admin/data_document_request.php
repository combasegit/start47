<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//school_sess.php を取り込む
include_once("./../inc/school_sess.php");
//ページ名
$PAGE_TITLE = "データ管理【資料請求】";

$_SESSION["key_s_date"] = date("Y/m/d", strtotime("-30 day"));//30日前
$_SESSION["key_e_date"] = date("Y/m/d", strtotime("+5 day"));//５日後
$_SESSION["key_all_day"] =1;


if($_REQUEST["search"]||$_REQUEST["del"]){
$mode="search";
	if($_REQUEST["del"]){
		//削除対象ID
		$del_id = $_REQUEST["del"];
		//del_flag立てる
		$del_sql = "UPDATE dtb_entry_client_school SET del_flag = '1' WHERE client_id = '$del_id' ";
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
	
	$k_sql = "select  m.*, d.* FROM mtb_client AS m , dtb_entry_client_school AS d WHERE m.client_id = d.client_id AND m.del_flag = '0' AND d.del_flag = '0' AND d.school_id = '$school_id' ";
	if(($_SESSION["key_all_day"]!='1')&&strlen($_SESSION["key_s_date"])&&strlen($_SESSION["key_e_date"])){
		$k_sql .= "AND d.insert_date BETWEEN '".$_SESSION["key_s_date"]."' AND '".$_SESSION["key_e_date"]."' ";
	}
	if(strlen($_SESSION["key_word"])){
		$k_sql .= "AND ((m.client_name like '%".$_SESSION["key_word"]."%') OR (m.client_name_kana like '%".$_SESSION["key_word"]."%') ";
	}
	$k_res = $mysqli->query($k_sql);#echo $k_sql;
	$k_cnt = $k_res->num_rows;

}elseif($_REQUEST["edit"]){
$mode="edit";
	//対象ID
	$client_id = $_REQUEST["edit"];
	//情報引き出し
	$sql = "select * from mtb_client where client_id = '$client_id' ";
	$res = $mysqli->query($sql);
	$data = $res->fetch_assoc();
	$insert_date=$data["insert_date"];
	$client_kind_id=$data["client_kind_id"];
	$client_name=$data["client_name"];
	$client_name_kana=$data["client_name_kana"];
	$age=$data["age"];
	$grade=$data["grade"];
	$sex=$data["sex"];
	$email=$data["email"];
	$email2=$data["email2"];
	$zip1=$data["zip1"];
	$zip2=$data["zip2"];
	$pref=$data["pref"];
	$addr=$data["addr"];
	$tel=$data["tel"];
	$entry_note=$data["entry_note"];
	$sc_info_mail=$data["sc_info_mail"];
	

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
if($mode!="edit"){
?>
					<div class="contents_box">
						<form class="form-search" action="" method="post">
							<h2>資料請求検索</h2>
							<div class="con">
								<div class="q_box">
									<div class="q_ttl">発生日</div>
									<div class="q_con">
										<label><input type="checkbox" name="key_all_day" value="1" <?if($_SESSION["key_all_day"]=='1'){echo "checked ";}?>/>全期間</label>　　
										<input type="text" name="key_s_date" value="<?=$_SESSION["key_s_date"]?>" id="datepicker">　～　
										<input type="text" name="key_e_date" value="<?=$_SESSION["key_e_date"]?>" id="datepicker2">
									</div>
								</div>
								<div class="q_box">
									<div class="q_ttl">名前キーワード<br />（フリガナ可）</div>
									<div class="q_con"><input type="text" name="key_word" value="<?=$_SESSION["key_word"]?>" /></div>
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
<?
if($k_cnt==0){
?>
							<p>この検索条件では結果は0件です。</p>
<?
}else{
?>
							<table>
								<thead>
									<tr>
										<th>No.</th>
										<th>氏名</th>
										<th>登録日</th>
										<th>内容</th>
									</tr>
								</thead>
								<tbody>
<?
while($k_data = $k_res->fetch_assoc()){$i++;
?>
									<tr>
										<td class="center"><?=$i?></td>
										<td class="center"><?=$k_data["client_name"]?></td>
										<td><?=$k_data["insert_date"]?></td>
										<td class="center">
											<form action="" method="post">
												<button type="submit" name="edit" value="<?=$k_data["client_id"]?>" class="btn btn-blue">確認</button>
												<button type="submit" name="del" value="<?=$k_data["client_id"]?>" class="btn btn-red" onclick="return confirm('本当に削除しますか？')">削除</button>
											</form>
										</td>
									</tr>
<?
}
?>
								</tbody>
<?
}
?>
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
							<h2><?=$PAGE_TITLE?>　資料請求内容</h2>
							<div class="con">
								<table>
									<tr>
										<th>資料請求発生時刻</th>
										<td>
											<?=$insert_date?>
										</td>
									</tr>
									<tr>
										<th>資料請求をされた方</th>
										<td>
											<?=$CLIENT_KIND[$client_kind_id]?>
											<input type="hidden" name="client_kind_id" value="<?=$client_kind_id?>" />
										</td>
									</tr>
									<tr>
										<th>お名前　<span class="red">(必須)</span></th>
										<td><?=$client_name?><input type="hidden" name="client_name" value="<?=$client_name?>" /></td>
									</tr>
									<tr>
										<th>フリガナ　<span class="red">(必須)</th>
										<td><?=$client_name_kana?><input type="hidden" name="client_name_kana" value="<?=$client_name_kana?>" /></td>
									</tr>
									<tr>
										<th>年齢　<span class="red">(必須)</th>
										<td><?=$age?>歳<input type="hidden" name="age" value="<?=$age?>" /></td>
									</tr>
									<tr>
										<th>学年　<span class="red">(必須)</th>
										<td><?=$GRADE_KIND[$grade]?><input type="hidden" name="grade" value="<?=$grade?>" /></td>
									</tr>
									<tr>
										<th>性別</th>
										<td><?=$SEX_ARY[$sex]?><input type="hidden" name="sex" value="<?=$sex?>" /></td>
									</tr>
									<tr>
										<th>メールアドレス<br /><span class="red">(必須)</th>
										<td><?=$email?><input type="hidden" name="email" value="<?=$email?>" /></td>
									</tr>
									<tr>
										<th>住所　<span class="red">(必須)</th>
										<td>
											〒<?=$zip1?>&nbsp;-<?=$zip2?><br /><?=$PREFECTURE[$pref]?><?=$addr?>
											<input type="hidden" name="zip1" value="<?=$zip1?>" />
											<input type="hidden" name="zip2" value="<?=$zip2?>" />
											<input type="hidden" name="pref" value="<?=$pref?>" />
											<input type="hidden" name="addr" value="<?=$addr?>" />
										</td>
									</tr>
									<tr>
										<th>電話番号　<span class="red">(必須)</th>
										<td><?=$tel?><input type="hidden" name="tel" value="<?=$tel?>" /></td>
									</tr>
									<tr>
										<th>備考</th>
										<td><?=nl2br($entry_note)?><input type="hidden" name="entry_note" value="<?=$entry_note?>" /></td>
									</tr>
									<tr>
										<th>学校からのお知らせ配信</th>
										<td>
											<?if($sc_info_mail=="1"){echo "希望する";}else{echo "しない";}?>
											<input type="hidden" name="sc_info_mail" value="<?=$sc_info_mail?>" />
										</td>
									</tr>
								</table>

							</div>
							<div class="submit_box">
								<!--<button type="submit" name="check_submit" value="check_submit" class="btn btn-blue">　処　理　</button>-->
								<button type="submit" name="" value="" class="btn btn-blue">　戻る　</button>
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