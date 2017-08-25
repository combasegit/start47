<?
//inc.php を取り込む
include_once("./inc/inc.php");
//sess.php を取り込む
include_once("./inc/sess.php");

$sql = "SELECT * FROM mtb_campus ";
$res = mysql_query($sql);
while($data = mysql_fetch_array($res)){
	$school_id = $data[school_id];
	$idset_flg = "ng";
	while($idset_flg == "ng"){
		$newid = mkrnd(6); // $idに6桁の乱数を与える
		$cntsql = "select count(*) as cnt from mtb_campus where campus_id = '$newid'";#echo $cntsql;
		$cntrs = mysql_query($cntsql);
		$cntdata = mysql_fetch_array($cntrs);
		if($cntdata["cnt"] == 0){
			$idset_flg = "ok";
		}
	}
	$up_sql = "UPDATE mtb_campus SET campus_id = '$newid' WHERE school_id = '$school_id' ";#echo $up_sql;
	#if(!( mysql_query($up_sql))){
	#	echo "■[".$school_id."] ERR<br />\n";
	#}else{
	##	echo $up_sql;
	#	echo "・[".$school_id."] OK!<br />\n";
	#}
}

?>
