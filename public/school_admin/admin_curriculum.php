<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//school_sess.php を取り込む
include_once("./../inc/school_sess.php");
//ページ名
$PAGE_TITLE = "学校情報管理【カリキュラム・コース】";
//カリキュラム最大登録数
#$max_curric_cnt=5;　→incファイルに移動


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
										<a href="/school/<?=$edit_school_id?>/curriculum.html" target="_blank" class="btn-prev btn">確認</a>
										<!--<a href="/school/<?=$edit_school_id?>/curriculum.html?prev=1" target="_blank" class="btn-prev btn">プレビュー</a>-->
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