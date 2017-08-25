<?
//画像アップフォルダ
if((stristr($_SERVER['PHP_SELF'], "/school/news/"))||(stristr($_SERVER['PHP_SELF'], "/school/opencampus/"))){
	$uploaddir = './../../school_img/';
}else{
	$uploaddir = './../school_img/';
}
//学校ID取得
$school_id = $_GET['school_id'];
//学校情報引き出し
$sql = "select * from mtb_school where school_id = '$school_id' AND del_flag = '0' ";
$res = $mysqli->query($sql);
$cnt = $res->num_rows;
if($cnt>0){
	$data = $res->fetch_assoc();
	$contract_rank = $data["contract_rank"];//	$CONTRACT_RANK_ARY = array("1"=>"フル有料", "5"=>"お試し", "10"=>"無料");
	$school_name = $data["school_name"];
	$school_type = $data["school_type"];
	$establish_type = $data["establish_type"];
	$representative = $data["representative"];
	$representative_email = $data["representative_email"];
	$catch_copy = $data["catch_copy"];
	$pr_txt = $data["pr_txt"];
	$many_from = $data["many_from"];
	$uniform = $data["uniform"];
	$schooling_level_memo = $data["schooling_level_memo"];
	$class_students = $data["class_students"];
	$rate_men = $data["rate_men"];
	$rate_women = $data["rate_women"];
	$rate_memo = $data["rate_memo"];
	
	//学校名文字数カウント
	$sc_name_cnt=mb_strlen($school_name);
	
	$schooling_title = $data["schooling_title"];
	$schooling_txt = $data["schooling_txt"];
	$regulation_title = $data["regulation_title"];
	$regulation_txt = $data["regulation_txt"];
	$club_title = $data["club_title"];
	$club_txt = $data["club_txt"];
	$event_title = $data["event_title"];
	$event_txt = $data["event_txt"];
	$admission_number = $data["admission_number"];
	$qualification_admission = $data["qualification_admission"];
	$admission_period = $data["admission_period"];
	$selection_process = $data["selection_process"];
	$entrance_fee = $data["entrance_fee"];
	$school_fee = $data["school_fee"];
	$material_fee = $data["material_fee"];
	$facility_fee = $data["facility_fee"];
	$sundry_expenses = $data["sundry_expenses"];
	$total_fee = $data["total_fee"];
	$fee_note = $data["fee_note"];
	
	//スクーリング頻度
	$l_sql = "SELECT * FROM dtb_school_schooling_level WHERE school_id = '$school_id' ";
	$l_res = $mysqli->query($l_sql);
	while($l_data = $l_res->fetch_assoc()){
		$schooling_level[]=$l_data[schooling_level];
	}

	//キャンパス情報引き出し
	$c_sql = "SELECT * FROM mtb_campus WHERE school_id = '$school_id' ORDER BY sort_id ";
	$c_res = $mysqli->query($c_sql);
	while($c_data = $c_res->fetch_assoc()){
		$CAMPUS_DATA[$c_data['campus_num']][campus_name]=$c_data['campus_name'];
		$CAMPUS_DATA[$c_data['campus_num']][pref]=$c_data['pref'];
		$CAMPUS_DATA[$c_data['campus_num']][zip1]=$c_data['zip1'];
		$CAMPUS_DATA[$c_data['campus_num']][zip2]=$c_data['zip2'];
		$CAMPUS_DATA[$c_data['campus_num']][address]=$c_data['address'];
		$CAMPUS_DATA[$c_data['campus_num']][tel]=$c_data['tel'];
		$CAMPUS_DATA[$c_data['campus_num']][access]=$c_data['access'];
		if($c_data['sort_id']=='0'){
			$THIS_SCHOOL_AREA=$c_data['area_id'];
			$THIS_SCHOOL_PREF=$c_data['pref'];
		}
	}
	
	//画像
	$path = $uploaddir.$school_id."/top_head.jpg";
	$path2 = $uploaddir.$school_id."/top_head.png";
	if (file_exists($path)) {
		$top_head_path = "./.".$path;
	} elseif (file_exists($path2)) {
		$top_head_path = "./.".$path2;
	} else {
		$top_head_path = "./.".$uploaddir."no_top_head.jpg";
	}
	$path = $uploaddir.$school_id."/thumb.jpg";
	$path2 = $uploaddir.$school_id."/thumb.png";
	if (file_exists($path)) {
		$thumb_path = "./.".$path;
	} elseif (file_exists($path2)) {
		$thumb_path = "./.".$path2;
	} else {
		$thumb_path = "./.".$uploaddir."no_thumb.jpg";
	}

	//お知らせ
	$n_sql = "select * from dtb_school_news where school_id = '$school_id' AND del_flag = '0' ORDER BY news_date DESC ";
	$n_res = $mysqli->query($n_sql);
	$n_cnt = $n_res->num_rows;

	//カリキュラム・コース
	$c_sql = "SELECT * FROM dtb_curriculum WHERE school_id = '$school_id' order by sort_id ";
	$c_res = $mysqli->query($c_sql);
	$c_cnt = $c_res->num_rows;

	//イベント情報
	$evt_sql = "select DISTINCT m.* FROM mtb_school_event AS m, dtb_event_date AS d ";
	$evt_sql .= "WHERE m.del_flag = '0' AND m.event_id = d.event_id AND m.school_id = '$school_id' ";
	$evt_res = $mysqli->query($evt_sql);
	$evt_cnt = $evt_res->num_rows;
	
}else{
	$err=1;
	$school_name="エラー";
}
?>