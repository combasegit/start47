<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//school_sess.php を取り込む
include_once("./../inc/school_sess.php");
//ページ名
$PAGE_TITLE = "学校情報管理【学校基本情報】";
//キャンパス最大登録数
$max_camp_cnt=60;


//画像アップフォルダ
$uploaddir = './../school_img/';
//最大画像サイズ（単位バイト。※１MB＝1024*1024バイト）
$file_size = 1024*1024*1;//1MB


if($_REQUEST["edit_submit"]){
	$mode="edit";
	//対象ID
	$edit_school_id = $school_id;
	//ｷｬﾝﾊﾟｽ多い学校は、特別に100件表示
	if($edit_school_id=="840730"||$edit_school_id=="888413"||$edit_school_id=="402605"||$edit_school_id=="649054"||$edit_school_id=="216505"||$edit_school_id=="585801"||$edit_school_id=="832663"||$edit_school_id=="645989"||$edit_school_id=="651427"||$edit_school_id=="284226"||$edit_school_id=="829920"||$edit_school_id=="837446"||$edit_school_id=="637270"||$edit_school_id=="301762"||$edit_school_id=="947828"||$edit_school_id=="524826"){
		$max_camp_cnt=100;
	}

	//データ受取
	$edit_contract_rank = $_REQUEST["edit_contract_rank"];
	$edit_password = $_REQUEST["edit_password"];
	$edit_school_name = $_REQUEST["edit_school_name"];
	$edit_school_type = $_REQUEST["edit_school_type"];
	$edit_establish_type = $_REQUEST["edit_establish_type"];
	$edit_representative = $_REQUEST["edit_representative"];
	$edit_representative_email = $_REQUEST["edit_representative_email"];
	$edit_info_email = $_REQUEST["edit_info_email"];
	$edit_catch_copy = $_REQUEST["edit_catch_copy"];
	$edit_pr_txt = $_REQUEST["edit_pr_txt"];
	$edit_many_from = $_REQUEST["edit_many_from"];
	$edit_uniform = $_REQUEST["edit_uniform"];
	$edit_schooling_level_memo = $_REQUEST["edit_schooling_level_memo"];
	$edit_schooling_level = $_REQUEST["edit_schooling_level"];//配列
	$edit_class_students = $_REQUEST["edit_class_students"];
	$edit_rate_men = $_REQUEST["edit_rate_men"];
	$edit_rate_women = $_REQUEST["edit_rate_women"];
	$edit_rate_memo = $_REQUEST["edit_rate_memo"];
	$edit_insert_date = $_REQUEST["edit_insert_date"];
	$edit_update_date = $_REQUEST["edit_update_date"];

	$check_file = $_REQUEST["check_file"];
	$check_file2 = $_REQUEST["check_file2"];

	$sortlst=$_REQUEST['sortlst'];//配列(並び順)
	#print_r($sortlst);
	$edit_campus_name=$_REQUEST['edit_campus_name'];//配列
	$edit_pref=$_REQUEST['edit_pref'];//配列
	$edit_zip1=$_REQUEST['edit_zip1'];//配列
	$edit_zip2=$_REQUEST['edit_zip2'];//配列
	$edit_address=$_REQUEST['edit_address'];//配列
	$edit_tel=$_REQUEST['edit_tel'];//配列
	$edit_access=$_REQUEST['edit_access'];//配列
	

	//入力チェック
	// パスワード
	 $ary = array(array("empty"),array("han"),
				 array("min", 5),
				 array("max", 20));
	 $chk = new CheckError($edit_password, "パスワード", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_password] = 1;
	 	 $errmsg[edit_password] = $chk->checkErrorAll();
	 }
	// 学校名
	 $ary = array(array("empty"),array("NGchar"),
				 array("maxZen", 40));
	 $chk = new CheckError($edit_school_name, "学校名", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_school_name] = 1;
	 	 $errmsg[edit_school_name] = $chk->checkErrorAll();
	 }
	// ご担当者
	 $ary = array(array("empty"),array("NGchar"),
				 array("maxZen", 20));
	 $chk = new CheckError($edit_representative, "ご担当者", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_representative] = 1;
	 	 $errmsg[edit_representative] = $chk->checkErrorAll();
	 }
	// ご担当者メールアドレス
	 $ary = array(array("empty"),array("email"),
				 array("NGchar"),
				 array("max", 50));
	 $chk = new CheckError($edit_representative_email, "ご担当者Eメール", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_representative_email] = 1;
	 	 $errmsg[edit_representative_email] = $chk->checkErrorAll();
	 }
	// お知らせ用メールアドレス
	 $chk = new CheckError($edit_info_email, "お知らせ用Eメール", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_info_email] = 1;
	 	 $errmsg[edit_info_email] = $chk->checkErrorAll();
	 }
	// キャッチコピー
	 $ary = array(array("NGchar"),
				 array("maxZen", 33));
	 $chk = new CheckError($edit_catch_copy, "キャッチコピー", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_catch_copy] = 1;
	 	 $errmsg[edit_catch_copy] = $chk->checkErrorAll();
	 }
	// 紹介文
	 $ary = array(array("NGchar"),
				 array("maxZen", 500));
	 $chk = new CheckError($edit_pr_txt, "紹介文", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_pr_txt] = 1;
	 	 $errmsg[edit_pr_txt] = $chk->checkErrorAll();
	 }
	// 入学者が多い地域
	 $ary = array(array("NGchar"),
				 array("maxZen", 50));
	 $chk = new CheckError($edit_many_from, "入学者が多い地域", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_many_from] = 1;
	 	 $errmsg[edit_many_from] = $chk->checkErrorAll();
	 }
	// 登校頻度補足
	 $ary = array(array("NGchar"),
				 array("maxZen", 100));
	 $chk = new CheckError($edit_schooling_level_memo, "登校頻度補足", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_schooling_level_memo] = 1;
	 	 $errmsg[edit_schooling_level_memo] = $chk->checkErrorAll();
	 }
	// クラス人数
	 $ary = array(array("num"),
				 array("max", 3));
	 $chk = new CheckError($edit_class_students, "クラス人数", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_class_students] = 1;
	 	 $errmsg[edit_class_students] = $chk->checkErrorAll();
	 }
	// 男女比
	 $ary = array(array("num"),
				 array("max", 2));
	 $chk = new CheckError($edit_rate_men, "男女比【男】", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_rate_men] = 1;
	 	 $errmsg[edit_rate_men] = $chk->checkErrorAll();
	 }
	 $chk = new CheckError($edit_rate_women, "男女比【女】", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_rate_women] = 1;
	 	 $errmsg[edit_rate_women] = $chk->checkErrorAll();
	 }
	// クラス人数補足
	 $ary = array(array("NGchar"),
				 array("maxZen", 100));
	 $chk = new CheckError($edit_rate_memo, "クラス人数補足", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_rate_memo] = 1;
	 	 $errmsg[edit_rate_memo] = $chk->checkErrorAll();
	 }

	for($i=1;$i<=$max_camp_cnt;$i++){
	// キャンパス名
	 $ary = array(array("NGchar"),
				 array("maxZen", 40));
	 $chk = new CheckError($edit_campus_name[$i], "【".$i."】名前", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_campus_name][$i] = 1;
	 	 $errmsg[edit_campus_name][$i] = $chk->checkErrorAll();
	 }
	// 郵便番号
	 $ary = array(array("num"),
				 array("max", 3));
	 $chk = new CheckError($edit_zip1[$i], "【".$i."】郵便番号３ケタ", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_zip1][$i] = 1;
	 	 $errmsg[edit_zip1][$i] = $chk->checkErrorAll();
	 }
	 $ary = array(array("num"),
				 array("max", 4));
	 $chk = new CheckError($edit_zip2[$i], "【".$i."】郵便番号４ケタ", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_zip2][$i] = 1;
	 	 $errmsg[edit_zip2][$i] = $chk->checkErrorAll();
	 }
	// 所在地
	 $ary = array(array("NGchar"),
				 array("maxZen", 50));
	 $chk = new CheckError($edit_address[$i], "【".$i."】所在地", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_address][$i] = 1;
	 	 $errmsg[edit_address][$i] = $chk->checkErrorAll();
	 }
	// 電話
	 $ary = array(array("han"),
				 array("max", 20));
	 $chk = new CheckError($edit_tel[$i], "【".$i."】電話番号", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_tel][$i] = 1;
	 	 $errmsg[edit_tel][$i] = $chk->checkErrorAll();
	 }
	// アクセス
	 $ary = array(array("NGchar"),
				 array("maxZen", 100));
	 $chk = new CheckError($edit_access[$i], "【".$i."】アクセス", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err[edit_access][$i] = 1;
	 	 $errmsg[edit_access][$i] = $chk->checkErrorAll();
	 }

	
	}

	//すべての入力項目に誤りが無ければDB登録
	if(!is_array($err)){
		$up_sql = "UPDATE mtb_school SET 
				password = '$edit_password', 
				school_name = '$edit_school_name', 
				school_type = '$edit_school_type', 
				establish_type = '$edit_establish_type', 
				representative = '$edit_representative', 
				representative_email = '$edit_representative_email', 
				info_email = '$edit_info_email', 
				catch_copy = '$edit_catch_copy', 
				pr_txt = '$edit_pr_txt', 
				many_from = '$edit_many_from', 
				uniform = '$edit_uniform', 
				schooling_level_memo = '$edit_schooling_level_memo', 
				class_students = '$edit_class_students', 
				rate_men = '$edit_rate_men', 
				rate_women = '$edit_rate_women', 
				rate_memo = '$edit_rate_memo', 
				update_date = now() 
				WHERE school_id = '$edit_school_id' ";
		if(!( $up_res = $mysqli->query($up_sql))){
			$err0 = 1;
			$errmsg0 = "DBの書き込みに失敗しました。お手数ですが、再度ご入力をお願いします。<br />";
		}else{
			//紐付きの削除
			$del_sql = "DELETE FROM dtb_school_schooling_level where school_id = '$edit_school_id' ";
			$del_res = $mysqli->query($del_sql);
			//新規紐付き登録
			if(is_array($edit_schooling_level)){
				foreach($edit_schooling_level as $val){
					$up2_sql = "INSERT INTO dtb_school_schooling_level (school_id, schooling_level) VALUES ('$edit_school_id', '$val') ";
					$up2_res = $mysqli->query($up2_sql);
				}
			}
			
			//既存キャンパス情報の削除
			$del_sql = "DELETE FROM mtb_campus where school_id = '$edit_school_id' ";
			$del_res = $mysqli->query($del_sql);
			//キャンパス情報登録
			for($i=1;$i<=$max_camp_cnt;$i++){
				if(strlen($edit_campus_name[$i])){//キャンパス名がある時だけ登録
					//キャンパスID裁番
					$idset_flg = "ng";
					while($idset_flg == "ng"){
						$newid = mkrnd(6); // $idに6桁の乱数を与える
						$cntsql = "select count(*) as cnt from mtb_campus where campus_id = '$newid'";#echo $cntsql;
						$cntrs = $mysqli->query($cntsql);
						$cntdata = $cntrs->fetch_assoc();
						if($cntdata["cnt"] == 0){
							$idset_flg = "ok";
						}
					}
					//エリアID変換
					if($edit_pref[$i]>39){
						$edit_area_id = 8;
					}elseif($edit_pref[$i]>35){
						$edit_area_id = 7;
					}elseif($edit_pref[$i]>30){
						$edit_area_id = 6;
					}elseif($edit_pref[$i]>24){
						$edit_area_id = 5;
					}elseif($edit_pref[$i]>20){
						$edit_area_id = 4;
					}elseif($edit_pref[$i]>14){
						$edit_area_id = 3;
					}elseif($edit_pref[$i]>7){
						$edit_area_id = 2;
					}else{
						$edit_area_id = 1;
					}
					//ソートID
					$edit_sort_id = array_search($i,$sortlst);
					$up_sql = "INSERT INTO mtb_campus (campus_id, school_id, campus_num, sort_id, campus_name, area_id, pref, zip1, zip2, address, tel, access, insert_date)
										 VALUES ('$newid','$edit_school_id','$i','$edit_sort_id','$edit_campus_name[$i]','$edit_area_id','$edit_pref[$i]','$edit_zip1[$i]','$edit_zip2[$i]','$edit_address[$i]','$edit_tel[$i]','$edit_access[$i]',now()) ";
					$up_res = $mysqli->query($up_sql);
				}
			}

			
			//サムネイル画像登録
			if($check_file!=1){
				//画像UP(含・上書き)
				if (strlen($_FILES['imgfile']['tmp_name'])) {
					$path = $_FILES['imgfile']['tmp_name'];
					$mime = shell_exec('file -bi '.escapeshellcmd($path));
					$mime = trim($mime);
					$mime = preg_replace("/ [^ ]*/", "", $mime);
					if(!strpos($mime,'jpeg')&&!strpos($mime,'jpg')&&!strpos($mime,'jp_')&&!strpos($mime,'png')){
						$err_img = 1;
						$errmsg_img ="サムネイル画像はJPEG・PNGファイルでは無いファイルのようです。JPEGかPNGファイルを選択してUPしてください。<br />";
					}else{
						//ディレクトリの有無を調べ、無ければ作成する
						if(!file_exists($uploaddir.$edit_school_id)){
							mkdir($uploaddir.$edit_school_id, 0777);
						}
						
						if(strpos($mime,'png')){//file-extension 拡張子
							$ext = ".png";
						}else{
							$ext = ".jpg";
						}
						$file_name = $edit_school_id."/thumb".$ext;
						$imagepath = $uploaddir . $file_name;
						if(move_uploaded_file($_FILES["imgfile"]["tmp_name"], $imagepath)){
							if( file_exists($imagepath)) {
								chmod($imagepath, 0777);
							}
						
						}else{
							$err_img = 1;
							$errmsg_img ="サムネイル画像の登録に失敗しました。画像サイズを確認してください。<br />";
						}
					}
				}
				
			}else{
				//画像削除
				$file_name = $edit_school_id."/thumb.jpg";
				$imagepath = $uploaddir . $file_name;
				if( file_exists($imagepath)) {
					unlink($imagepath);
				}
				$file_name2 = $edit_school_id."/thumb.png";
				$imagepath2 = $uploaddir . $file_name2;
				if( file_exists($imagepath2)) {
					unlink($imagepath2);
				}
			}
			//top_head画像登録
			if($check_file2!=1){
				//画像UP(含・上書き)
				if (strlen($_FILES['imgfile2']['tmp_name'])) {
					$path = $_FILES['imgfile2']['tmp_name'];
					$mime = shell_exec('file -bi '.escapeshellcmd($path));
					$mime = trim($mime);
					$mime = preg_replace("/ [^ ]*/", "", $mime);
					if(!strpos($mime,'jpeg')&&!strpos($mime,'jpg')&&!strpos($mime,'jp_')&&!strpos($mime,'png')){
						$err_img = 1;
						$errmsg_img .="学校TOP画像はJPEG・PNGファイルでは無いファイルのようです。JPEGかPNGファイルを選択してUPしてください。<br />";
					}else{
						//ディレクトリの有無を調べ、無ければ作成する
						if(!file_exists($uploaddir.$edit_school_id)){
							mkdir($uploaddir.$edit_school_id, 0777);
						}
						
						if(strpos($mime,'png')){//file-extension 拡張子
							$ext = ".png";
						}else{
							$ext = ".jpg";
						}
						$file_name = $edit_school_id."/top_head".$ext;
						$imagepath = $uploaddir . $file_name;
						if(move_uploaded_file($_FILES["imgfile2"]["tmp_name"], $imagepath)){
							if( file_exists($imagepath)) {
								chmod($imagepath, 0777);
							}
						
						}else{
							$err_img = 1;
							$errmsg_img .="学校TOP画像の登録に失敗しました。画像サイズを確認してください。<br />";
						}
					}
				}
				
			}else{
				//画像削除
				$file_name = $edit_school_id."/top_head.jpg";
				$imagepath = $uploaddir . $file_name;
				if( file_exists($imagepath)) {
					unlink($imagepath);
				}
				$file_name2 = $edit_school_id."/top_head.png";
				$imagepath2 = $uploaddir . $file_name2;
				if( file_exists($imagepath2)) {
					unlink($imagepath2);
				}
			}


			$ok=1;
			
			
		}
	}
	
}else{
$mode="edit";
	//対象ID
	$edit_school_id = $school_id;//ログイン中のID
	//ｷｬﾝﾊﾟｽ多い学校は、特別に100件表示
	if($edit_school_id=="840730"||$edit_school_id=="888413"||$edit_school_id=="402605"||$edit_school_id=="649054"||$edit_school_id=="216505"||$edit_school_id=="585801"||$edit_school_id=="832663"||$edit_school_id=="645989"||$edit_school_id=="651427"||$edit_school_id=="284226"||$edit_school_id=="829920"||$edit_school_id=="837446"||$edit_school_id=="637270"||$edit_school_id=="301762"||$edit_school_id=="947828"||$edit_school_id=="524826"){
		$max_camp_cnt=100;
	}
	//既存情報引き出し
	$sql = "select * from mtb_school where school_id = '$edit_school_id' AND del_flag = '0' ";
	$res = $mysqli->query($sql);
	$data = $res->fetch_assoc();
	$edit_password = $data["password"];
	$edit_contract_rank = $data["contract_rank"];
	$edit_school_name = $data["school_name"];
	$edit_school_type = $data["school_type"];
	$edit_establish_type = $data["establish_type"];
	$edit_representative = $data["representative"];
	$edit_representative_email = $data["representative_email"];
	$edit_info_email = $data["info_email"];
	$edit_catch_copy = $data["catch_copy"];
	$edit_pr_txt = $data["pr_txt"];
	$edit_many_from = $data["many_from"];
	$edit_uniform = $data["uniform"];
	$edit_schooling_level_memo = $data["schooling_level_memo"];
	$edit_class_students = $data["class_students"];
	$edit_rate_men = $data["rate_men"];
	$edit_rate_women = $data["rate_women"];
	$edit_rate_memo = $data["rate_memo"];
	$edit_insert_date = $data["insert_date"];
	$edit_update_date = $data["update_date"];
	
	//紐付き引き出し
	$l_sql = "SELECT * FROM dtb_school_schooling_level WHERE school_id = '$edit_school_id' ";
	$l_res = $mysqli->query($l_sql);
	while($l_data = $l_res->fetch_assoc()){
		$edit_schooling_level[]=$l_data[schooling_level];
	}
	
	//キャンパス情報引き出し
	$c_sql = "SELECT * FROM mtb_campus WHERE school_id = '$edit_school_id' order by sort_id ";
	$c_res = $mysqli->query($c_sql);
	while($c_data = $c_res->fetch_assoc()){$z++;
		$edit_campus_num[$z]=$c_data['campus_num'];
		$edit_campus_name[$z]=$c_data['campus_name'];
		$edit_pref[$z]=$c_data['pref'];
		$edit_zip1[$z]=$c_data['zip1'];
		$edit_zip2[$z]=$c_data['zip2'];
		$edit_address[$z]=$c_data['address'];
		$edit_tel[$z]=$c_data['tel'];
		$edit_access[$z]=$c_data['access'];
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
						<div class="top">編集が完了しました。</div>
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
										<a href="/school/<?=$edit_school_id?>/" target="_blank" class="btn-prev btn">確認</a>
										<!--<a href="/school/<?=$edit_school_id?>/?prev=1" target="_blank" class="btn-prev btn">プレビュー</a>-->
									</div>
								</div>
								<div class="q_box">
									<div class="q_ttl">掲載</div>
									<div class="q_con">
										<?=$CONTRACT_RANK_ARY[$edit_contract_rank]?>
										<input type="hidden" name="edit_contract_rank" value="<?=$edit_contract_rank?>" />
									</div>
								</div>
								<div class="q_box<?if($err[edit_password]==1){echo " err_bg";}?>">
									<div class="q_ttl">PW</div>
									<div class="q_con"><input type="text" name="edit_password" value="<?=$edit_password?>" /><?if($err[edit_password]==1){echo "<span class=\"esg\">※".$errmsg[edit_password]."</span>";}?></div>
								</div>
								<div class="q_box<?if($err[edit_school_name]==1){echo " err_bg";}?>">
									<div class="q_ttl">学校名</div>
									<div class="q_con"><input type="text" name="edit_school_name" value="<?=$edit_school_name?>" class="w500" /><?if($err[edit_school_name]==1){echo "<span class=\"esg\">※".$errmsg[edit_school_name]."</span>";}?></div>
								</div>
								<div class="q_box">
									<div class="q_ttl">学校種別</div>
									<div class="q_con">
										<?foreach($SCHOOL_TYPE_ARY as $k=>$val){?>
										<label><input type="radio" name="edit_school_type" value="<?=$k?>" <?if($edit_school_type==$k){echo "checked";}?>/><?=$val?></label>　　
										<?}?>
									</div>
								</div>
								<div class="q_box">
									<div class="q_ttl">設立種別</div>
									<div class="q_con">
										<?foreach($ESTABLISH_TYPE_ARY as $k=>$val){?>
										<label><input type="radio" name="edit_establish_type" value="<?=$k?>" <?if($edit_establish_type==$k){echo "checked";}?>/><?=$val?></label>　　
										<?}?>
									</div>
								</div>
								<div class="q_box<?if($err[edit_representative]==1){echo " err_bg";}?>">
									<div class="q_ttl">ご担当者様</div>
									<div class="q_con"><input type="text" name="edit_representative" value="<?=$edit_representative?>" /><?if($err[edit_representative]==1){echo "<span class=\"esg\">※".$errmsg[edit_representative]."</span>";}?></div>
								</div>
								<div class="q_box<?if($err[edit_representative_email]==1){echo " err_bg";}?>">
									<div class="q_ttl">ご担当者様Eメール</div>
									<div class="q_con"><input type="text" name="edit_representative_email" value="<?=$edit_representative_email?>" /><span class="red">※サイトには表示されません</span><?if($err[edit_representative_email]==1){echo "<span class=\"esg\">※".$errmsg[edit_representative_email]."</span>";}?></div>
								</div>
								<div class="q_box<?if($err[edit_info_email]==1){echo " err_bg";}?>">
									<div class="q_ttl">お知らせ用Eメール</div>
									<div class="q_con"><input type="text" name="edit_info_email" value="<?=$edit_info_email?>" /><span class="red">※資料請求などのお知らせが届きます</span><?if($err[edit_info_email]==1){echo "<span class=\"esg\">※".$errmsg[edit_info_email]."</span>";}?></div>
								</div>
								<div class="q_box<?if($err[edit_catch_copy]==1){echo " err_bg";}?>">
									<div class="q_ttl">キャッチコピー</div>
									<div class="q_con"><input type="text" name="edit_catch_copy" class="w500" value="<?=$edit_catch_copy?>" placeholder="全角33文字以内" /><?if($err[edit_catch_copy]==1){echo "<span class=\"esg\">※".$errmsg[edit_catch_copy]."</span>";}?></div>
								</div>
								<div class="q_box<?if($err[edit_pr_txt]==1){echo " err_bg";}?>">
									<div class="q_ttl">紹介文</div>
									<div class="q_con"><textarea name="edit_pr_txt" class="w500 h120" placeholder="全角200文字以内" ><?=$edit_pr_txt?></textarea><?if($err[edit_pr_txt]==1){echo "<span class=\"esg\">※".$errmsg[edit_pr_txt]."</span>";}?></div>
								</div>
								<div class="q_box<?if($err[edit_many_from]==1){echo " err_bg";}?>">
									<div class="q_ttl">入学者が多い地域</div>
									<div class="q_con"><input type="text" name="edit_many_from" value="<?=$edit_many_from?>" /><?if($err[edit_many_from]==1){echo "<span class=\"esg\">※".$errmsg[edit_many_from]."</span>";}?></div>
								</div>
								<div class="q_box">
									<div class="q_ttl">制服</div>
									<div class="q_con">
										<label><input type="radio" name="edit_uniform" value="1" <?if($edit_uniform==1){echo "checked";}?>/>制服あり</label>　　
										<label><input type="radio" name="edit_uniform" value="0" <?if($edit_uniform==0){echo "checked";}?>/>制服なし</label>　　
										<label><input type="radio" name="edit_uniform" value="2" <?if($edit_uniform==2){echo "checked";}?>/>制服あり（私服も可）</label>
									</div>
								</div>
								<div class="q_box<?if($err[edit_schooling_level_memo]==1){echo " err_bg";}?>">
									<div class="q_ttl">登校頻度</div>
									<div class="q_con">
										<?foreach($SCHOOLING_LEVEL_ARY as $k=>$val){?>
										<label><input type="checkbox" name="edit_schooling_level[]" value="<?=$k?>" <?if(in_array($k,$edit_schooling_level)){echo "checked";}?>/><?=$val?></label>　　
										<?}?><br />
										[補　足]　<input type="text" name="edit_schooling_level_memo" value="<?=$edit_schooling_level_memo?>" style="width:450px;" />
										<?if($err[edit_schooling_level_memo]==1){echo "<span class=\"esg\">※".$errmsg[edit_schooling_level_memo]."</span>";}?>
									</div>
								</div>
								<div class="q_box<?if($err[edit_class_students]==1||$err[edit_rate_men]==1||$err[edit_rate_women]==1||$err[edit_rate_memo]==1){echo " err_bg";}?>">
									<div class="q_ttl">クラス人数</div>
									<div class="q_con">
										[１クラス]約<input type="text" name="edit_class_students" value="<?=$edit_class_students?>" style="width:30px;" maxlength="3" />人　　[男女比]　男性<input type="text" name="edit_rate_men" value="<?=$edit_rate_men?>" style="width:20px;" maxlength="3" />：女性<input type="text" name="edit_rate_women" value="<?=$edit_rate_women?>" style="width:20px;" maxlength="3" /><br />
										[補　足]　<input type="text" name="edit_rate_memo" value="<?=$edit_rate_memo?>" style="width:450px;" /><br />
										<?if($err[edit_class_students]==1){echo "<span class=\"esg\">※".$errmsg[edit_class_students]."</span>";}?>
										<?if($err[edit_rate_men]==1){echo "<span class=\"esg\">※".$errmsg[edit_rate_men]."</span>";}?>
										<?if($err[edit_rate_women]==1){echo "<span class=\"esg\">※".$errmsg[edit_rate_women]."</span>";}?>
										<?if($err[edit_rate_memo]==1){echo "<span class=\"esg\">※".$errmsg[edit_rate_memo]."</span>";}?>
									</div>
								</div>
<?
	$path = $uploaddir.$edit_school_id."/thumb.jpg";
	$path2 = $uploaddir.$edit_school_id."/thumb.png";
	if (file_exists($path)) {
		$image_path = $path;
	} elseif (file_exists($path2)) {
		$image_path = $path2;
	} else {
		$image_path = $uploaddir."no_thumb.jpg";
	}
?>
								<div class="q_box">
									<div class="q_ttl">サムネイル画像</div>
									<div class="q_con">
										画像はJPGかPNGで、1MB以下のファイルをご使用ください。<span class="red">推奨サイズ（横）180px（縦）180px</span><br />
										<a href="<?=$image_path?>" target="_blank"><img src="<?=$image_path?>" width="180px"/></a>クリックで実寸表示<br />
<?
	if (file_exists($path)||file_exists($path2)) {
?>
										<input type="checkbox" name="check_file" value="1" id="check_file" /><label for="check_file" class="check_css">削除</label><font class="red">（※イメージを変更する場合は、削除フラグをチェックしないでください。）</font><br />
<?
	} else {
		echo "<br />";
	}
?>
										<input name="imgfile" size="28" type="file" /><br /><br />
									</div>
								</div>
<?
	$path = $uploaddir.$edit_school_id."/top_head.jpg";
	$path2 = $uploaddir.$edit_school_id."/top_head.png";
	if (file_exists($path)) {
		$image_path = $path;
	} elseif (file_exists($path2)) {
		$image_path = $path2;
	} else {
		$image_path = $uploaddir."no_top_head.jpg";
	}
?>
								<div class="q_box">
									<div class="q_ttl">学校TOP画像</div>
									<div class="q_con">
										画像はJPGかPNGで、1MB以下のファイルをご使用ください。<span class="red">推奨サイズ（横）820px（縦）280px</span><br />
										<a href="<?=$image_path?>" target="_blank"><img src="<?=$image_path?>" width="205px"/></a>クリックで実寸表示<br />
<?
	if (file_exists($path)||file_exists($path2)) {
?>
										<input type="checkbox" name="check_file2" value="1" id="check_file2" /><label for="check_file2" class="check_css">削除</label><font class="red">（※イメージを変更する場合は、削除フラグをチェックしないでください。）</font><br />
<?
	} else {
		echo "<br />";
	}
?>
										<input name="imgfile2" size="28" type="file" /><br /><br />
									</div>
								</div>

								<div class="q_box">
									<div class="q_ttl">キャンパス情報</div>
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
	width:650px;
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
									<?for($i=1;$i<=$max_camp_cnt;$i++){?>
										<div id="box<?=$i?>" class="box">
										<input type="hidden" name="sortlst[]" value="<?=$i?>">
										<dt<?if($err[edit_campus_name][$i]==1||$err[edit_zip1][$i]==1||$err[edit_zip2][$i]==1||$err[edit_address][$i]==1||$err[edit_tel][$i]==1||$err[edit_access][$i]==1){echo " class=\"err_bg\"";}?>>キャンパス【<?=$i?>】<input type="text" name="edit_campus_name[<?=$i?>]" value="<?=$edit_campus_name[$i]?>" style="width:350px;" /><?if($err[edit_campus_name][$i]==1){echo "<span class=\"esg fs10\">※".$errmsg[edit_campus_name][$i]."</span>";}?></dt>
										<dd>
										<table class="tb_con">
											<tr>
												<th>所在地</th>
												<td<?if($err[edit_zip1][$i]==1||$err[edit_zip2][$i]==1||$err[edit_address][$i]==1){echo " class=\"err_bg\"";}?>>
													〒<input type="text" size="3" maxlength="3" name="edit_zip1[<?=$i?>]" value="<?=$edit_zip1[$i]?>" />-<input type="text" size="4" maxlength="4" name="edit_zip2[<?=$i?>]" value="<?=$edit_zip2[$i]?>" />
													<select name="edit_pref[<?=$i?>]">
<?
	foreach($PREFECTURE as $k=>$tmp){
?>
														<option value="<?=$k?>"<?if($edit_pref[$i]==$k){echo " selected";}?>><?echo $tmp;?></option>
<?
	}
?>
													</select><br />
													<input name="edit_address[<?=$i?>]" type="text" value="<?=$edit_address[$i]?>" style="ime-mode: auto;width:500px;" /><br />
													<?if($err[edit_zip1][$i]==1){echo "<span class=\"esg fs10\">※".$errmsg[edit_zip1][$i]."</span>";}?>
													<?if($err[edit_zip2][$i]==1){echo "<span class=\"esg fs10\">※".$errmsg[edit_zip2][$i]."</span>";}?>
													<?if($err[edit_address][$i]==1){echo "<span class=\"esg fs10\">※".$errmsg[edit_address][$i]."</span>";}?>
												</td>
											</tr>
											<tr>
												<th>電話</th>
												<td<?if($err[edit_tel][$i]==1){echo " class=\"err_bg\"";}?>>
													<input type="text" name="edit_tel[<?=$i?>]" value="<?=$edit_tel[$i]?>" />
													<?if($err[edit_tel][$i]==1){echo "<span class=\"esg fs10\">※".$errmsg[edit_tel][$i]."</span>";}?>
												</td>
											</tr>
											<tr>
												<th>アクセス</th>
												<td<?if($err[edit_access][$i]==1){echo " class=\"err_bg\"";}?>>
													<textarea name="edit_access[<?=$i?>]" style="width:500px;height:120px;"><?=$edit_access[$i]?></textarea>
													<?if($err[edit_access][$i]==1){echo "<span class=\"esg fs10\">※".$errmsg[edit_access][$i]."</span>";}?>
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