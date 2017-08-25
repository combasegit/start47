<?
//inc.php を取り込む
include_once("./inc/inc.php");
//sess.php を取り込む
include_once("./inc/sess.php");

if($_REQUEST["school_id"]){//学校IDがあれば処理
	$school_id = $_REQUEST["school_id"];
	//■クッキー保存
	$cookie = "WatchSid"; // Cookieの名前
	$period = time() + 365*24*3600; // Cookieの有効期限(1年)
	if(isset($_COOKIE[$cookie])) {
		$sid_ary=explode(",",$_COOKIE[$cookie]);
		if(!in_array($school_id, $sid_ary)){
			setcookie($cookie, $_COOKIE[$cookie].",".$school_id, $period, '/');
		}else{
			setcookie($cookie, $_COOKIE[$cookie], $period, '/');//有効期限だけ上書き
		}
	}else{
		setcookie($cookie, $school_id, $period, '/');
	}


}elseif($_REQUEST["all_watch"]){//まとめてウォッチリスト追加
	if($_REQUEST["check_lst"]){
		$check_lst=$_REQUEST["check_lst"];
		$check_lst_ary=implode(",",$check_lst);//文字列に変換
		//■クッキー保存
		$cookie = "WatchSid"; // Cookieの名前
		$period = time() + 365*24*3600; // Cookieの有効期限(1年)
		if(isset($_COOKIE[$cookie])) {
			$check_lst_ary = array_unique($_COOKIE[$cookie].",".$check_lst_ary);//重複した要素を削除
			setcookie($cookie, $check_lst_ary, $period, '/');
		}else{
			setcookie($cookie, $check_lst_ary, $period, '/');
		}
	}

}elseif($_REQUEST["del_scool_id"]){//学校IDがあれば削除処理
	$property_id = $_REQUEST["del_scool_id"];
	//■クッキー保存
	$cookie = "WatchSid"; // Cookieの名前
	$period = time() + 365*24*3600; // Cookieの有効期限(1年)
	if(isset($_COOKIE[$cookie])) {
		$pid_ary=explode(",",$_COOKIE[$cookie]);
		if(in_array($property_id, $pid_ary)){
			//一覧から抜く
			$_COOKIE[$cookie] = str_replace($property_id,'',$_COOKIE[$cookie]);
			$pid_ary=explode(",",$_COOKIE[$cookie]);//再度配列化
			$pid_ary=array_filter($pid_ary);//空要素を詰める
			$_COOKIE[$cookie] = implode(",",$pid_ary);//再度文字列に
			setcookie($cookie, $_COOKIE[$cookie], $period, '/');
		}else{
			setcookie($cookie, $_COOKIE[$cookie], $period, '/');//有効期限だけ上書き
		}
	}else{
		setcookie($cookie, $property_id, $period, '/');
	}
}//来たページに戻す
header("Location: ".$_SERVER["HTTP_REFERER"]);


?>
