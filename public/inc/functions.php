<?php

	// タグを除去（未使用）
	function tag_remove($param, $removed_tags = ""){

		// 引数が配列ではない場合は、標準
		if(!is_array($removed_tags)){
			unset($removed_tags);
			global $removed_tags;
		}

		// htmlから特定タグを取り除く
		$rm_html = new TagRemover($param, $removed_tags);
		return $rm_html->remove();

	}

	// タグを除去（全て）
	function tag_all_remove($param){

		// htmlから特定タグを取り除く
		$rm_html = new TagAllRemover($param);
		return $rm_html->remove();

	}

	// 半角カタカナチェック
	function half_kana_check($param){
		$param2 = HANtoZEN($param, 1);
		if($param == $param2){
			return FALSE;
		}
		else{
			return TRUE;
		}
	}

	// 機種依存文字チェック
	function dpnd_wrd_check($param){
		$param = EUCtoSJIS($param);
		for($i = 0; $i < mb_strlen($param, "SJIS"); $i++){
			$str = mb_substr($param, $i, 1, "SJIS");
			$hex = ("0x" . bin2hex($str)) * 1;

			// 13区の特殊文字
			if($hex >= 0x8740 && $hex <= 0x879F) return TRUE;

			// NEC選定IBM拡張文字
			if($hex >= 0xED40 && $hex <= 0xEEFC) return TRUE;

			// IBM拡張文字
			if($hex >= 0xFA40 && $hex <= 0xFC4B) return TRUE;

			// 外字
			if($hex >= 0xF040 && $hex <= 0xF9FC) return TRUE;

			// Mac
			if($hex >= 0x8540 && $hex <= 0x889E) return TRUE;

			// Mac外字及び縦組用
			if($hex >= 0xEAA5 && $hex <= 0xFCFC) return TRUE;

		}
	}

	// タグチェック
	function tag_check($param, $permit_tags = "", $permit_attrs = ""){

		// 引数が配列ではない場合は、標準
		if(!is_array($permit_tags)){
			unset($permit_tags);
			global $permit_tags;
		}
		if(!is_array($permit_attrs)){
			unset($permit_attrs);
			global $permit_attrs;
		}

		// htmlから特定タグを取得し、存在結果を返す（0:許可タグ以外のタグがある 1:正常）
		$tc = new tag_checker($param, $permit_tags, $permit_attrs);
		return $tc->check();

	}

	// SQLをエスケープ
	function ass($param){
		return addslashes($param);
	}

	// SQLをエスケープを外す
	function sss($param){
		return stripslashes($param);
	}

	// HTMLをエスケープ
	function hsc($param){
		$str = htmlspecialchars(sss($param));
		return mb_convert_kana($str,"KV");
	}

	// 表示をエスケープ
	function disp($param){
		return nl2br($param);
	}

	// ゼロで埋める
	function zerofill($string, $digit = 2){

		while(strlen($string) < $digit){
			$string = "0" . $string;
		}

		return $string;

	}

	// タイムスタンプの取得
	function get_timestamp($digit = 14){

		if($digit < 8){
			$digit = 8;
		}
		elseif($digit < 14){
			$digit = 8;
		}
		elseif($digit > 14){
			$digit = 14;
		}

		$now = getdate();
		$y = $now["year"];
		$m = zerofill($now["mon"]);
		$d = zerofill($now["mday"]);
		$h = zerofill($now["hours"]);
		$mi = zerofill($now["minutes"]);
		$s = zerofill($now["seconds"]);
		$datetime = substr($y . $m . $d . $h . $mi . $s, 0, $digit);
		$fmt = substr($datetime, 0, 4) . "-" . substr($datetime, 4, 2) . "-" . substr($datetime, 6, 2);
		if($digit > 8){
			$fmt .= " " . substr($datetime, 8, 2) . ":" . substr($datetime, 10, 2) . ":" . substr($datetime, 12, 2);
		}

		return $fmt;

	}

	// 配列をつめる
	function array_adjust($param){
		if(is_array($param)){
			$new_array = array();
			foreach($param as $p){
				if($p){
					array_push($new_array, $p);
				}
			}
			return $new_array;
		}
		else{
			return $param;
		}
	}

	// 乱数を生成
	function mkrnd($length = 10){

		// パスワード文字列の配列を作成
		$pwelemstr = "abcdefghkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ0123456789";
		$pwelem = preg_split("//", $pwelemstr, 0, PREG_SPLIT_NO_EMPTY);

		// パスワード文字列を作成する
		$str = "";
		for($i=0; $i<$length; $i++ ) {

			// 乱数表のシードを決定
			srand(microtime() * 1000000);

			// パスワード文字列を生成
			$str .= $pwelem[rand(0, count($pwelem) - 1)];

		}

		return $str;

	}

	// 改行コード除去
	function remove_crlf($param, $replace = ""){
		$param = str_replace("\r\n", $replace, $param);
		$param = str_replace("\r",   $replace, $param);
		$param = str_replace("\n",   $replace, $param);
		return $param;
	}

	// 半角カンマを全角カンマへ
	function comma_escape($param){
		$param = str_replace(",", "，", $param);
		return $param;
	}

	// CSVエスケープ
	function csv_escape($param, $replace = ""){
		return sss(comma_escape(remove_crlf($param, $replace)));
	}

	// 文字列を区切って、最後の値を取得
	function get_tail($div, $param){
		$arr = explode($div, $param);
		$soeji = count($arr) - 1;
		return $arr[$soeji];
	}

	// 設定ファイルを読み込み、連想配列を返す
	function get_property($filename, $rev = FALSE){

		$arr = array();

		// ファイルを開く
		if(file_exists($filename)){
			$lines = file($filename);

			// ファイルをループ
			foreach($lines as $line){

				// 改行コードの除去
				$line = remove_crlf($line);

				// イコールで区切る
				list($name, $value) = split("=", $line);

				// 連想配列を作る
				if($rev){
					$arr[$value] = $name;
				}
				else{
					$arr[$name] = $value;
				}

			}

			// 連想配列を返す
			return $arr;

		}
		else{
			return FALSE;
		}

	}

	// syslog
	function write_log($level, $mod, $msg){

		// 出力制限をかける
		switch(LOG_MODE){

			// LV4以上を出力
			case 2:

				// LV4以上に当てはまらない場合は関数を抜ける
				if($level != LOG_LV4 && $level != LOG_LV3 && $level != LOG_LV2 && $level != LOG_LV1){
					return FALSE;
				}

				break;

			// LV3以上を出力
			case 3:

				// LV3以上に当てはまらない場合は関数を抜ける
				if($level != LOG_LV3 && $level != LOG_LV2 && $level != LOG_LV1){
					return FALSE;
				}

				break;

		}

		// ログフォーマットを取得
		$log = LOG_FMT;

		// 日付の置換
		$log = str_replace("%D", date("Y/m/d H:i:s"), $log);

		// セッションIDの置換
		$log = str_replace("%S", session_id(), $log);

		// プロセスIDの置換
		$log = str_replace("%P", posix_getpid(), $log);

		// IPアドレスの置換
		$log = str_replace("%I", $_SERVER["REMOTE_ADDR"], $log);

		// ログレベルの置換
		$log = str_replace("%L", $level, $log);

		// モジュール名の置換
		$log = str_replace("%O", $mod, $log);

		// メッセージの置換
		$log = str_replace("%M", $_SERVER["PHP_SELF"] . ": " . $msg, $log);

		// メッセージの改行コードを削る
		$log = remove_crlf($log) . "\n";

		// ログディレクトリが無い場合は、生成
		mk_path2dir(SET_LOG_DIR);

		// ファイル名を決定
		$filename = SET_LOG_DIR . "/" . get_timestamp(8) . ".log";

		// ファイルポインタを生成（追記モード）
		$fp = fopen($filename, "a") ;

		// ファイルを書き込みロック
		flock($fp, LOCK_EX);

		// ファイルに追記
		fputs($fp, $log);

		// ファイルポインタを閉じる
		fclose($fp);

		// ファイルのパーミッションを変更
		chmod($filename, SET_MKFILE_PERMISSION);

	}

	// 同ホストからのリンクか判断
	function ref_chk(){
		if(ereg($_SERVER["HTTP_HOST"], $_SERVER["HTTP_REFERER"])){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	// 連想配列をname=value;に分解
	function implode_hash($arr, $skip = ""){

		// スキップする連想配列のキーを定義
		if($skip){
			$names = split(",", $skip);
			foreach($names as $name){
				$skips[$name] = 1;
			}
		}

		$str = "";
		$cnt = 0;
		while(list($name, $value) = each($arr)){
			if(!$skips[$name]){
				$str .= $name . "=" . $value . "; ";
				$cnt++;
			}
		}

		if($cnt > 0){
			return $str;
		}
		else{
			return FALSE;
		}

	}


	// パスからディレクトリ生成
	function mk_path2dir($path){

		// パスを配列へ分解
		$arr = split("/", $path);

		// パスをループ
		$tmp_path = "";
		for($i = 0; $i < count($arr); $i++){
			$tmp_path .= $arr[$i] . "/";
			if(!is_dir($tmp_path)){
				mkdir($tmp_path);
				chmod($tmp_path, SET_MKDIR_PERMISSION);
			}
		}

	}

	// 日付を整形して取得
	function get_date_format($param, $format){

		// パラメータが空白ではないか
		if($param != ""){

			// 日付と時刻に区切る
			list($date, $time) = split(" ", $param);
			if($time == ""){
				$time = $date;
			}

			// 年月日に分割
			list($year, $month, $day) = split("-", $date);

			// 時分秒に分割
			list($hour, $minute, $second) = split(":", $time);

			// フォーマットを置換
			$format = str_replace("%Y", $year,   $format);
			$format = str_replace("%M", $month,  $format);
			$format = str_replace("%D", $day,    $format);
			$format = str_replace("%H", $hour,   $format);
			$format = str_replace("%m", $minute, $format);
			$format = str_replace("%S", $second, $format);

			// 返却
			return $format;

		}
		else{
			return FALSE;
		}

	}

	// ファイルを削除
	function rm_file($file){

		if(file_exists($file)){
			return unlink($file);
		}
		else{
			return FALSE;
		}

	}

	// ディレクトリを丸々コピーする
	function copy_directory($dir_from, $dir_to){

		if(!is_dir($dir_to)){
			if(mkdir($dir_to)){
				chmod($dir_to, SET_MKDIR_PERMISSION);
			}
			else{
				return FALSE;
			}
		}

		// 元のディレクトリの中身を取得
		$dir = opendir($dir_from);
		while($file = readdir($dir)){
			if($file != "." && $file != ".." ){
				if(is_dir($dir_from . "/" . $file)){
					if(!copy_directory($dir_from . "/" . $file, $dir_to . "/" . $file)){
						return FALSE;
					}
				}
				else{

					if(!copy($dir_from . "/" . $file, $dir_to . "/" . $file) && filesize($dir_from . "/" . $file) > 0){
						return FALSE;
					}
					else{
						chmod($dir_to . "/" . $file, SET_MKFILE_PERMISSION);
					}

				}
			}
		}

		return TRUE;

	}

	// ディレクトリを削除
	function rm_directory($param, $rm_myself = TRUE){

		if(is_dir($param)){

			// ディレクトリ内の全てのファイルを消去
			$dir = opendir($param);
			while($file = readdir($dir)){
				if($file != "." && $file != ".." ){
					if(is_dir($param . "/" . $file)){
						if(!rm_directory($param . "/" . $file)){
							return FALSE;
						}
					}
					else{
						if(!rm_file($param . "/" . $file)){
							return FALSE;
						}
					}
				}
			}

			// ディレクトリを削除
			if($rm_myself){
				return rmdir($param);
			}

		}
		else{

			// ファイルを削除
			if($rm_myself){
				return rm_file($param);
			}
			else{
				return TRUE;
			}

		}

	}

	// 処理終了
	function exit_proc(){
		write_log(LOG_LV4, "php", SET_LOG_PROC_END);
	}

	// HTTPヘッダ（ロケーション）発行
	function location($url){
		write_log(LOG_LV4, "php", "location: " . $url);
		exit_proc();
		header("Location: " . $url);
		exit;
	}

	// コマンド実行
	function exec_cmd($param){
		$result = exec($param);
		write_log(LOG_LV4, "php", "command: " . $param);
		write_log(LOG_LV4, "php", "command res: " . $result);
	}

	// 画像かどうかチェックし、拡張子を返す
	function img_check($path){
		if(file_exists($path)){

			global $img_mime_type;

			$size = getimagesize($path);
			$mime = $size["mime"];

			return $img_mime_type[$mime];

		}
		else{
			return FALSE;
		}
	}

	// 画像のMIMEタイプを返す
	function get_mime($path){
		if(file_exists($path)){

			$size = getimagesize($path);
			return $size["mime"];

		}
		else{
			return FALSE;
		}
	}

	// エラーハンドラー
	function err_handler($errno, $errmsg, $filename, $linenum, $vars){

		// エラーナンバーによって処理を分ける
		switch($errno){

			case E_ERROR:
			case E_WARNING:
			case E_PARSE:
			case E_CORE_ERROR:
			case E_CORE_WARNING:
			case E_COMPILE_ERROR:
			case E_COMPILE_WARNING:

				// ログを出力
				write_log(LOG_LV2, "php", "errno=" . $errno . "; errmsg=" . $errmsg . "; filename=" . $filename . "; linenum=" . $linenum . "; vars=" . implode_hash($vars));

				// エラーページへ移動
				location("error.php");
				break;

			case E_NOTICE:
			case E_USER_ERROR:
			case E_USER_WARNIN:
			case E_USER_NOTICE:

				// ログを出力
				write_log(LOG_LV5, "php", "errno=" . $errno . "; errmsg=" . $errmsg . "; filename=" . $filename . "; linenum=" . $linenum . "; " . implode_hash($vars));
				break;

		}

	}


	// HTTPリクエストを出し、結果を取得
	function get_http_body($url, $method = "GET", $headers = "", $post = array("")){

		global $err;

		// Methodを大文字に統一
		$method = strtoupper($method);

		// URLを分解
		$info = parse_url($url);

		// クエリー
		if(isset($info['query'])) {
			$info['query'] = "?" . $info['query'];
		}
		else{
			$info['query'] = "";
		}

		// デフォルトのポートは80
		if(!isset($info['port'])){
			$info['port'] = 80;
		}

		// リクエストラインを定義
		$request  = $method . " " . $info['path'] . $info['query'] . " HTTP/1.0\r\n";

		// リクエストヘッダを定義
		$request .= "Host: " . $info['host'] . "\r\n";
		$request .= "User-Agent: PHP/" . phpversion() . "\r\n";

		// Basic認証用のヘッダ
		if(isset($info['user']) && isset($info['pass'])) {
			$request .= "Authorization: Basic " . base64_encode($info['user'] . ":" . $info['pass']) . "\r\n";
		}

		// 追加ヘッダを追加
		$request .= $headers;

		// POSTの時はヘッダを追加して末尾にURLエンコードしたデータを添付
		if(strtoupper($method) == "POST") {
			while(list($name, $value) = each($post)) {
				$POST[] = $name . "=" . urlencode($value);
			}
			$postdata = implode("&", $POST);
			$request .= "Content-Type: application/x-www-form-urlencoded\r\n";
			$request .= "Content-Length: " . strlen($postdata) . "\r\n";
			$request .= "\r\n";
			$request .= $postdata;
		}
		else{
			$request .= "\r\n";
		}

		// WEBサーバへ接続
		$fp = fsockopen($info['host'], $info['port']);

		// 接続に失敗した時の処理
		if(!$fp){
			return FALSE;
		}

		// 要求データ送信
		fputs($fp, $request);

		// 応答データ受信
		$response = "";
		while (!feof($fp)) {
			$response .= fgets($fp, 4096);
		}

		// 接続を終了
		fclose($fp);

		// ヘッダ部分とボディ部分を分離
		list($result_header, $result_body) = split("\r\n\r\n", $response, 2);

		// ボディ部分を返す
		if($method != "HEAD"){
			return $result_body;
		}
		else{
			return $result_header;
		}

	}

	// ファイル名をチェックして、不正な文字が含まれていた場合はランダムな値を設定して返す
	function filename_chk($filename){

		// 不正な文字があった場合
		if(ereg("[^0-9a-zA-Z._-]", $filename)){
			return mkrnd() . "." . get_tail(".", $filename);
		}

		// 不正な文字が無かった場合
		else{
			return $filename;
		}
	}

	// ファイルを保存する
	function save($path, $value, $mode = "w"){

		// ファイルを保存
		$fp = fopen($path, $mode);
		fwrite($fp, $value);
		fclose($fp);

	}

	// 日付から年齢を計算する（引数は、YYYY-MM-DD形式で渡す）
	function get_age($birth){

	    $ty = date("Y");
	    $tm = date("m");
	    $td = date("d");
	    list($by, $bm, $bd) = explode('-', $birth);
	    $age = $ty - $by;
	    if($tm * 100 + $td < $bm * 100 + $bd) $age--;
	    return $age;

	}

	// メール送信
	function send_mail($mail_to, $subject, $message, $mail_fr, $mail_fr_name, $err_to_address){

		mb_language('Japanese');
		mb_internal_encoding('UTF-8'); 

		$subject = mb_convert_encoding( $subject, "JIS", "UTF-8" );
		$subject = base64_encode($subject);
		$subject = '=?ISO-2022-JP?B?' . $subject . '?=';
		$message = mb_convert_encoding( $message, "JIS", "UTF-8" );
		$from = mb_convert_encoding( $mail_fr_name, "JIS", "UTF-8" );
		$from = "From:=?ISO-2022-JP?B?" . base64_encode($from) . "?= <$mail_fr>"; 
		$sendmail_param="-f".$err_to_address;



		// メール送信
		#return mail($mail_to,$subject,$message,$from,$sendmail_param);//SEAFMODEでは使えない第五
		return mail($mail_to,$subject,$message,$from);
	}

//----------------------------------------------------------
// デザイン関連関数
//----------------------------------------------------------

	// 文字列を比較し、セレクトボックスの選択コードを返す
	function get_selected($param1, $param2, $str = "selected"){

		if("$param1" == "$param2"){
			return $str;
		}
		else{
			return FALSE;
		}

	}

	// 文字列を比較し、セレクトボックス
	function get_clrsample($code){

		// 入力されているか
		if($code != ""){

			// 正しいカラー指定フォーマットか
			if(ereg("[0-9a-fA-F]{6}", $code)){
				return "<font color=\"#" . hsc($code) . "\">■</font>";
			}
			else{
				return "";
			}

		}

		else{
			return "";
		}
	}


	// パラメータが空白の場合、NULL文字を返す
	// パラメータが空白ではない場合はメタ文字をエスケープし、シングルコーテーションを付けて返す
	function get_column_value($param){

		// 空白の場合
		if($param == "" || $param == "0000-00-00 00:00:00" || $param == "0000-00-00" || $param == "00:00:00"){
			return "NULL";
		}

		// 空白ではない場合
		else{
			return "'" . ass($param) . "'";
		}

	}

	// 必須入力文字を返す
	function get_notnull($param){
		if($param){
			return "[必須]";
		}
		else{
			return "";
		}
	}

//----------------------------------------------------------
// チェック関連関数
//----------------------------------------------------------

	// 数字かどうかチェック
	function is_numeric2($param){

		// NULLまたは空白の時、エラーを起こさないために
		if(!$param){
			$param = "0";
		}

		return !ereg("[^0-9]", $param);
	}

	// 英字かどうかチェック
	function is_alphabet($param){
		return !ereg("[^a-zA-Z]", $param);
	}

	// 英数字かどうかチェック
	function is_alphanumeric($param){
		return !ereg("[^0-9a-zA-Z]", $param);
	}

	// 半角文字かどうかチェック
	function is_half($param){
		return strlen($param) == mb_strlen($param);
	}

	// カラーコードかどうかチェック
	function is_color($param){
		return !ereg("[^0-9a-fA-F]", $param) && strlen($param) == 6;
	}

	// メールかどうかチェック
	function is_email($param){
		return eregi("^[a-z0-9\._-]+@+[a-z0-9\._-]+\.+[a-z]{2,4}$", $param);
	}

	// URLかどうかチェック
	function is_url($param){
		if($param){
			if(preg_match("/http\:\/\/[\w\.\~\-\/\?\&\+\=\:\@\%\#]+/", $param)){
				return TRUE;
			}
		}
		return FALSE;
	}

	// 電話番号かどうかチェック
	function is_tel($param){
		$nums = split("-", $param);
		foreach($nums as $num){
			if(!is_numeric($num)){
				return FALSE;
			}
		}
		return TRUE;
	}

	// 日付かどうかチェック(YYYY-MM-DDの形式で渡すこと)
	function is_date($param){
		return @checkdate(get_date_format($param, "%M"), get_date_format($param, "%D"), get_date_format($param, "%Y"));
	}

	// 時刻かどうかチェック(HH:mm:SSの形式で渡すこと)
	function is_time($param){
		$hour   = get_date_format($param, "%H");
		$minute = get_date_format($param, "%m");
		$second = get_date_format($param, "%S");
		if(!is_numeric($hour) || $hour < 0 || $hour >= 24){
			return FALSE;
		}
		if(!is_numeric($minute) || $minute < 0 || $minute >= 60){
			return FALSE;
		}
		if(!is_numeric($second) || $second < 0 || $second >= 60){
			return FALSE;
		}
		return TRUE;
	}

	// 日付・時刻かどうかチェック(YYYY-MM-DD HH:mm:SSの形式で渡すこと)
	function is_datetime($param){
		$year   = get_date_format($param, "%Y");
		$month  = get_date_format($param, "%M");
		$day    = get_date_format($param, "%D");
		$hour   = get_date_format($param, "%H");
		$minute = get_date_format($param, "%m");
		$second = get_date_format($param, "%S");

		// 日付のチェック
		if(!is_date($year . "-" . $month . "-" . $day)){
			return FALSE;
		}

		// 時刻のチェック
		if(!is_time($hour . ":" . $minute . ":" . $second)){
			return FALSE;
		}

		return TRUE;
	}

	// アカウントに使用できる文字（英数字または_（アンダースコア））かどうかチェック
	function is_account($param){
		return !ereg("[^0-9a-zA-Z_]", $param);
	}

	// 文字コードを変換
	function mb_e2s($param){
		return mb_convert_encoding($param, "SJIS", "EUC-JP");
	}

	// 文字コードを変換(逆ver)
	function mb_s2e($param){
		return mb_convert_encoding($param, "EUC-JP", "SJIS");
	}
	
	// 文字コードを変換
	function mb_e2u($param){
		return mb_convert_encoding($param, "UTF-8", "EUC-JP");
	}
	// 文字コードを変換
	function mb_u2e($param){
		return mb_convert_encoding($param, "EUC-JP", "UTF-8");
	}

	// 挨拶
	function greet(){
		$notime = date("H", time());

		if($notime>=5){
			if($notime>=11){
				if($notime>=16){
					return "こんばんは！";
				}else{
					return "こんにちは！";
				}
			}else{
				return "おはようございます！";
			}
		}else{
			return "こんばんは！";
		}
	}

?>