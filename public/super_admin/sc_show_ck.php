<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//admin_sess.php を取り込む
include_once("./../inc/admin_sess.php");

$to_mode="";
$school_id="";

if($_REQUEST["to_mode"]){
	$to_mode = $_REQUEST["to_mode"];
}
if($_REQUEST["school_id"]){
	$school_id = $_REQUEST["school_id"];
}

if($to_mode=="on"){
	//「表示中」に上書き
			$up_sql = "UPDATE mtb_school SET show_flag = '1', update_date = now() WHERE school_id = '$school_id' ";
			$up_res = $mysqli->query($up_sql);
}elseif($to_mode=="off"){
	//「非表示」に上書き
			$up_sql = "UPDATE mtb_school SET show_flag = '0', update_date = now() WHERE school_id = '$school_id' ";
			$up_res = $mysqli->query($up_sql);
}


?>