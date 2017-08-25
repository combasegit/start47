<?
//inc.php を取り込む
include_once("./inc/inc.php");
//sess.php を取り込む
include_once("./inc/sess.php");
/*
$sql = "select * from mtb_school where plaza_id != '' ";
$res = $mysqli->query($sql);
while($data = $res->fetch_assoc()){
	$school_id = $data[school_id];
	$plaza_id = $data[plaza_id];
	$school_name = $data[school_name];
	foreach($PREFECTURE as $k=>$vv){
		if(mb_strstr($school_name, $vv)){
			$pref=$k;
		}
	}
	if($pref>39){
		$area_id = 8;
	}elseif($pref>35){
		$area_id = 7;
	}elseif($pref>30){
		$area_id = 6;
	}elseif($pref>24){
		$area_id = 5;
	}elseif($pref>20){
		$area_id = 4;
	}elseif($pref>14){
		$area_id = 3;
	}elseif($pref>7){
		$area_id = 2;
	}else{
		$area_id = 1;
	}
	#$up_sql = "UPDATE mtb_school SET establish_type = '1'  WHERE school_id = '$school_id' ";
	#$up_res = $mysqli->query($up_sql);
	#echo $up_sql."<br>\n";
	
	#$url = "http://www.tsuushinsei-plaza.com/school/".$plaza_id."/";
	#$html = file_get_contents($url);
	#if(preg_match_all('/<td itemprop="streetAddress">(.+?)<\/td>/msi', $html, $result_list)){
	#	$html = $result_list[1][0];
	#	echo $html."<br>\n";
	#	$up_sql = "UPDATE mtb_school SET campus_data = '$html' WHERE school_id = '$school_id' ";
	#	$up_res = $mysqli->query($up_sql);
	#	$i++;#echo $i;
	#}
	
	
	
}
*/

$sql = "select * from mtb_school where plaza_id != '' ";
$res = $mysqli->query($sql);
while($data = $res->fetch_assoc()){
	$school_id = $data[school_id];
	$school_name = $data[school_name];
	$campus_data = $data[campus_data];
	#echo $campus_data;
	if(preg_match_all('/〒(.+?) /msi', $campus_data, $result_list)){
		$zips = strip_tags($result_list[1][0]);
		$zip1=substr($zips, 0, 3);
		$zip2=substr($zips, 4, 4);
	}else{
		$zips = "";
		$zip1 = "";
		$zip2 = "";
	}
	$pref = "";
	$address = "";
	$addr_lst=explode(" ",$campus_data);
	$address=mb_convert_kana($addr_lst[1], 'a');
	#echo $addr;
	foreach($PREFECTURE as $k=>$vv){
		if(mb_strstr($address, $vv)){
			$pref=$k;
			$address=str_replace($vv,"",$address);
			break;
		}
	}
	if($pref>39){
		$area_id = 8;
	}elseif($pref>35){
		$area_id = 7;
	}elseif($pref>30){
		$area_id = 6;
	}elseif($pref>24){
		$area_id = 5;
	}elseif($pref>20){
		$area_id = 4;
	}elseif($pref>14){
		$area_id = 3;
	}elseif($pref>7){
		$area_id = 2;
	}else{
		$area_id = 1;
	}

	//自動裁番
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
	//DB登録
	$up_sql = "INSERT INTO mtb_campus (campus_id, school_id, campus_num, campus_name, zip1, zip2, area_id, pref, address, insert_date)
						 VALUES ('$newid','$school_id',1,'$school_name','$zip1','$zip2','$area_id','$pref','$address',now()) ";
	#$up_res = $mysqli->query($up_sql);
	echo $up_sql."<br>\n";


}


?>
