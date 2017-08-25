<?
//inc.php を取り込む
include_once("./inc/inc.php");
//sess.php を取り込む
include_once("./inc/sess.php");
/*
$sql = "select * from mtb_school where navi_id != '' ";
$res = $mysqli->query($sql);
while($data = $res->fetch_assoc()){
	$school_id = $data[school_id];
	$navi_id = $data[navi_id];
	$url = "http://www.tsuushinsei-navi.com/detail/".$navi_id."/";
	$html = file_get_contents($url);
	if(preg_match_all('/<div class="place">(.+?)<\/div>/msi', $html, $result_list)){
		$html = $result_list[1][0];
		#echo $html;
		#$up_sql = "UPDATE mtb_school SET campus_data = '$html' WHERE school_id = '$school_id' ";
		#$up_res = $mysqli->query($up_sql);
		$i++;echo $i;
	}
	
	
	
}
*/

$sql = "select * from mtb_school where navi_id != '' ";
$res = $mysqli->query($sql);
while($data = $res->fetch_assoc()){
	$school_id = $data[school_id];
	$campus_data = $data[campus_data];
	#echo $campus_data;
	if(preg_match_all('/入学できる都道府県<\/h3>\\n\\t\\t<p>(.+?)<\/p>/msi', $campus_data, $result_list)){
		$many_from = strip_tags($result_list[1][0]);
	}else{
		$many_from = "";
	}

	if(preg_match_all('/<table class="border">(.+?)<\/table>/msi', $campus_data, $result_list)){
		$i=0;
		foreach($result_list[0] as $val){$i++;
				#echo "【".$i."】".$val;
				if(preg_match_all('/<th class="name" colspan="3">(.+?)<\/th>/msi', $val, $res_list)){
					$campus_name = strip_tags($res_list[1][0]);
				}else{
					$campus_name = "";
				}
				if(preg_match_all('/<th>住　所<\/th>\\n\\t\\t<td> 〒(.+?)<\/td>/msi', $val, $res_list)){
					$base_address = strip_tags($res_list[1][0]);
					$zip1=substr($base_address, 0, 3);
					$zip2=substr($base_address, 4, 4);
					$address=substr($base_address, 9);
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

				}else{
					$zip1 = "";
					$zip2 = "";
					$area_id = "";
					$pref = "";
					$address = "";
				}
				if(preg_match_all('/<th>電　話<\/th>\\n\\t\\t<td colspan="2">(.+?)<\/td>/msi', $val, $res_list)){
					$tel = strip_tags($res_list[1][0]);
				}else{
					$tel = "";
				}
				if(preg_match_all('/<th>アクセス<\/th>\\n\\t\\t<td colspan="2">(.+?)<\/td>/msi', $val, $res_list)){
					$access = strip_tags($res_list[1][0]);
				}else{
					$access = "";
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
				$up_sql = "INSERT INTO mtb_campus (campus_id, school_id, campus_num, campus_name, zip1, zip2, area_id, pref, address, tel, access, insert_date)
									 VALUES ('$newid','$school_id','$i','$campus_name','$zip1','$zip2','$area_id','$pref','$address','$tel','$access',now()) ";
				#$up_res = $mysqli->query($up_sql);
				echo $up_sql."<br>\n";
				
				
		}
	}


}


?>
