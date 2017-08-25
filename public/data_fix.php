<?
//inc.php を取り込む
include_once("./inc/inc.php");
//sess.php を取り込む
include_once("./inc/sess.php");

// ファイルを開く
$data = file("./school01.txt"); 

#print_r($data);

foreach($data as $val){$k++;
	$sc_data="";//初期化
	$sc_data=explode(',',$val);
	$sc_name=$sc_data[0];
	$sc_type=$sc_data[1];
	if($sc_type=="通信制高校"){
		$sc_type_id=1;
	}elseif($sc_type=="通信制サポート校"){
		$sc_type_id=2;
	}elseif($sc_type=="技能連携校"){
		$sc_type_id=3;
	}
	$sc_add_txt=$sc_data[2];
	$sc_zip1=substr($sc_add_txt,0,3);
	$sc_zip2=substr($sc_add_txt,4,4);
	$sc_add=substr($sc_add_txt,9);

	//id自動裁番
	$idset_flg = "ng";
	while($idset_flg == "ng"){
		$newid = rand(100000,999999); // $idに6桁の乱数を与える
		$cntsql = "select count(*) as cnt from mtb_school where school_id = '$newid'";
		$cntrs = mysql_query($cntsql);
		$cntdata = mysql_fetch_array($cntrs);
		if($cntdata["cnt"] == 0){
			$idset_flg = "ok";
		}
	}
	//PW生成
	$sc_password = mkrnd();

	//DB登録
	$up_sql = "insert into mtb_school (school_id, password, school_name, school_type, zip1, zip2, address, insert_date) values ";
	$up_sql .= "('$newid', '$sc_password', '$sc_name', '$sc_type_id', '$sc_zip1', '$sc_zip2', '$sc_add', now()) ";
	#if(!( mysql_query($up_sql))){
	#	echo "■[".$k."] ERR<br />\n";
	#}else{
	##	echo $up_sql;
	#	echo "・[".$k."] OK!<br />\n";
	#}
}

?>
