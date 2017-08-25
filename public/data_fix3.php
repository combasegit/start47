<?
//inc.php を取り込む
include_once("./inc/inc.php");
//sess.php を取り込む
include_once("./inc/sess.php");

$sql = "SELECT * FROM mtb_campus WHERE pref_id = '0' ";
$res = mysql_query($sql);
while($data = mysql_fetch_array($res)){
	$pref_id = "";
	$address = "";
	$campus_id = $data[campus_id];
	$address = $data[address];
	foreach($PREFECTURE as $p => $p_name){
		if(strstr($address,$p_name)){
			$pref_id = $p;
			break;
		}
	}
	$address = mb_eregi_replace($p_name,"",$address);
	
	$up_sql = "UPDATE mtb_campus SET pref_id = '$pref_id', address= '$address' WHERE campus_id = '$campus_id' ";#echo $up_sql;
	if(!( mysql_query($up_sql))){
		echo "■[".$campus_id."] ERR<br />\n";
	}else{
	#	echo $up_sql;
		echo "・[".$campus_id."] OK!<br />\n";
	}
}

?>
