<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//admin_sess.php を取り込む
include_once("./../inc/admin_sess.php");
//ページ名
$PAGE_TITLE = "学校情報管理【カリキュラム・コース】";


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


	$sortlst=$_REQUEST['sortlst'];//配列(並び順)
	#print_r($sortlst);
	$edit_curriculum_title=$_REQUEST['edit_curriculum_title'];//配列
	$edit_curriculum_txt=$_REQUEST['edit_curriculum_txt'];//配列
	
	

	//入力チェック
	for($i=1;$i<=$max_curric_cnt;$i++){
	// ｶﾘｷｭﾗﾑ名
	 $ary = array(array("NGchar"),
				 array("maxZen", 40));
	 $chk = new CheckError($edit_curriculum_title[$i], "【".$i."】ｶﾘｷｭﾗﾑ名", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_curriculum_title][$i] = 1;
	 	 $errmsg[edit_curriculum_title][$i] = $chk->checkErrorAll();
	 }
	// 内容
	 $ary = array(array("NGchar"),
				 array("maxZen", 2000));
	 $chk = new CheckError($edit_curriculum_txt[$i], "【".$i."】内容", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_curriculum_txt][$i] = 1;
	 	 $errmsg[edit_curriculum_txt][$i] = $chk->checkErrorAll();
	 }

	
	}

	//すべての入力項目に誤りが無ければDB登録
	if(!is_array($err)){
			//既存ｶﾘｷｭﾗﾑ情報の削除
			$del_sql = "DELETE FROM dtb_curriculum where school_id = '$edit_school_id' ";
			$del_res = $mysqli->query($del_sql);
			//ｶﾘｷｭﾗﾑ情報登録
			for($i=1;$i<=$max_curric_cnt;$i++){
				if(strlen($edit_curriculum_title[$i])){//ｶﾘｷｭﾗﾑ名がある時だけ登録
					//ｶﾘｷｭﾗﾑID裁番
					$idset_flg = "ng";
					while($idset_flg == "ng"){
						$newid = mkrnd(6); // $idに6桁の乱数を与える
						$cntsql = "select count(*) as cnt from dtb_curriculum where curriculum_id = '$newid'";#echo $cntsql;
						$cntrs = $mysqli->query($cntsql);
						$cntdata = $cntrs->fetch_assoc();
						if($cntdata["cnt"] == 0){
							$idset_flg = "ok";
						}
					}
					//ソートID
					$edit_sort_id = array_search($i,$sortlst);
					$up_sql = "INSERT INTO dtb_curriculum (curriculum_id, school_id, curriculum_num, sort_id, curriculum_title, curriculum_txt, insert_date)
										 VALUES ('$newid','$edit_school_id','$i','$edit_sort_id','$edit_curriculum_title[$i]','$edit_curriculum_txt[$i]',now()) ";
					if(!( $up_res = $mysqli->query($up_sql))){
						$err0 = 1;#echo $up_sql;
						$errmsg0 = "DBの書き込みに失敗しました。お手数ですが、再度ご入力をお願いします。<br />既にDBには、情報はありませんので必ずご入力ください<br />";
						break;
					}else{
						$up_sql = "UPDATE mtb_school SET update_date = now() WHERE school_id = '$edit_school_id' ";
						$up_res = $mysqli->query($up_sql);
						$ok=1;
					}
				}
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
	
	
	//ｶﾘｷｭﾗﾑ情報引き出し
	$c_sql = "SELECT * FROM dtb_curriculum WHERE school_id = '$edit_school_id' order by sort_id ";
	$c_res = $mysqli->query($c_sql);
	while($c_data = $c_res->fetch_assoc()){$z++;
		$edit_curriculum_num[$z]=$c_data['curriculum_num'];
		$edit_curriculum_title[$z]=$c_data['curriculum_title'];
		$edit_curriculum_txt[$z]=$c_data['curriculum_txt'];
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
    <link rel="stylesheet" href="./css/jquery-ui-1.9.2.custom.min.css" />
    <!--<script type="text/javascript" src="./js/jquery-1.8.3.js"></script>-->
    <script type="text/javascript" src="./js/jquery-ui-1.9.2.custom.min.js"></script>
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
										<a href="/school/<?=$edit_school_id?>/curriculum.html" target="_blank" class="btn-prev btn">確認</a>
										<!--<a href="/school/<?=$edit_school_id?>/curriculum.html?prev=1" target="_blank" class="btn-prev btn">プレビュー</a>-->
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
								<div class="q_box">
									<div class="q_ttl">カリキュラム情報</div>
									<div class="q_con"><span class="red">※クリックで展開、ドラッグで並び替えが出来ます。</span>
<style type="text/css">
#acMenu dt{
	display:block;
	width:650px;
	height:40px;
	line-height:40px;
	text-align:center;
	border:#666 1px solid;
	cursor:pointer;
	}
#acMenu dd{
	width:650px;
	display:none;
	}
#acMenu dd table{
	width:100%;
	}
.fs10{
	font-size:10px;
}
.box {
position: relative;
background-color: #ffffff;
text-align: center;
}

.box:hover {
background-color: #EBEFF8;
box-shadow: 0 0 7px rgba(50,50,50,0.3);
-moz-box-shadow: 0 0 7px rgba(50,50,50,0.3);
-webkit-box-shadow: 0 0 7px rgba(50,50,50,0.3);
}
</style>
<script>
	$(document).ready(function(){
	    $("#acMenu").sortable();
	});
	$(function(){
		$("#acMenu dt").on("click", function() {
			$(this).next().slideToggle();
		});
	});
</script>
									<dl id="acMenu">
									<?for($i=1;$i<=$max_curric_cnt;$i++){?>
										<div id="box<?=$i?>" class="box">
										<input type="hidden" name="sortlst[]" value="<?=$i?>">
										<dt<?if($err[edit_curriculum_title][$i]==1||$err[edit_curriculum_txt][$i]==1){echo " class=\"err_bg\"";}?>>【<?=$i?>】<input type="text" style="width:450px;" name="edit_curriculum_title[<?=$i?>]" value="<?=$edit_curriculum_title[$i]?>" /><?if($err[edit_curriculum_title][$i]==1){echo "<span class=\"esg fs10\">※".$errmsg[edit_curriculum_title][$i]."</span>";}?></dt>
										<dd>
										<table class="tb_con">
											<tr>
												<th>内容</th>
												<td<?if($err[edit_curriculum_txt][$i]==1){echo " class=\"err_bg\"";}?>>
													<textarea style="width:500px;height:300px;" name="edit_curriculum_txt[<?=$i?>]"><?=$edit_curriculum_txt[$i]?></textarea>
													<?if($err[edit_curriculum_txt][$i]==1){echo "<span class=\"esg fs10\">※".$errmsg[edit_curriculum_txt][$i]."</span>";}?>
												</td>
											</tr>
										</table>
										</dd>
										</div>
									<?}?>
									</dl>
									</div>
								</div>

									<?if($mode=="edit"){?>
								<div class="q_box">
									<div class="q_ttl">データ登録日</div>
									<div class="q_con"><?=$edit_insert_date?><input type="hidden" name="edit_insert_date" value="<?=$edit_insert_date?>" /></div>
								</div>
								<div class="q_box">
									<div class="q_ttl">データ最終更新日</div>
									<div class="q_con"><?=$edit_update_date?><input type="hidden" name="edit_update_date" value="<?=$edit_update_date?>" /></div>
								</div>
								<?}?>
							</div>
							<div class="submit_box">
								<?if($mode=="edit"){?>
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