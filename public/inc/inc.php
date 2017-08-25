<?php
require_once("functions.php");
require_once("CheckError_class.php");

//----------------------------------------------------------
// PHP設定
//----------------------------------------------------------
	ini_set( 'display_errors', "1" );//共有サーバエラー非表示対策（開発時のみ使用でいいかな？）
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	error_reporting(E_ERROR);
//----------------------------------------------------------
// データベース関連定数
//----------------------------------------------------------
	// データベースタイプ
	define("SQLHOST", "o4012-259.kagoya.net");

	// データベースユーザ
	define("SQLUSER", "kir705907");

	// データベースパスワード
	define("SQLPASS", "motokashi355");

	// データベース（スキーマ）名
	define("SQLDATABASE", "db_start47");

//----------------------------------------------------------
// 共通定数
//----------------------------------------------------------
	// サイトドメイン
	define("SET_SITE_DOMAIN", "start47.com");
	
	// TOPディレクトリ
	#define("SET_ROOT_DIR", "/dev");
	define("SET_ROOT_DIR", "");

	// サイト名
	define("SET_SITE_TITLE", "通信制高校からはじめよう【START47】");
	// サイト名ショートVer.
	define("SET_SITE_TITLE_S", "通信制高校からはじめよう");

	// META説明文（Description）
	define("SET_META_DESCRIPTION", "通信制高校からはじめよう【START47】は、通信制高校に通おうとするお子様と保護者の方に向けて、お子様に最適な通信制高校探しのお手伝いをするサイトです。");

	// METAキーワード（keywords）
	define("SET_META_KEYWORDS", "通信制高校,サポート校,学費,検索,比較,通学,制服,卒業,就職");
	define("SET_META_KEYWORDS_S", "通信制高校,サポート校,はじめよう,START47");


	// 著作権
	define("SET_COPYRIGHT", "Copyright &copy; " . date("Y") . " ACSEL Co.,Ltd. All Rights Reserved.");

	// サイト担当者名
	define("SET_SITE_MASTER", "通信制高校START47");

	// サイトURL
	define("SET_SITE_URL", "https://start47.com/");
	
	// サイトお問い合わせ用メール
	define("SET_SITE_MAIL", "info@start47.com");
	define("SET_SITE_MAIL2", "arai@combase.jp");
	define("SET_SITE_MAIL_NOREPLY", "no-reply@start47.com");
	
	//管理者の種類
	$ADMIN_RANK_ARY = array("A"=>"最高管理者","B"=>"一般管理者");
	
	// 許可するタグ（小文字で統一すること）
	global $permit_tags;
	$permit_tags = array();

	// 許可するタグの属性（小文字で統一すること）
	global $permit_attrs;
	$permit_attrs = array();

	//許可タグ意外のタグが含まれていた場合のエラーメッセージ
	define("ERR_NOT_PERMIT_TAGS", "に不正なタグ・または属性が使用されています。");

	// 半角カタカナが含まれていた場合のエラーメッセージ
	define("ERR_HALF_KANA_EXISTS", "に半角カタカナが使用されています。");

	// 機種依存文字が含まれていた場合のエラーメッセージ
	define("ERR_DPND_WRD_EXISTS", "に機種依存文字が使用されています。");

	// 画像のMIMEタイプ
	global $img_mime_type;
	$img_mime_type = array(
//	                      "image/gif" => ".gif",
	                      "image/pjpeg"  => ".jpg",
                          "image/jpeg"  => ".jpg");

	// 画像のMIMEタイプ
	global $img_mime_type1;
	$img_mime_type1 = array(
//	                      "image/gif" => ".gif",
	                      "image/pjpeg"  => ".jpg",
                          "image/jpeg"  => ".jpg");

	// 画像のMIMEタイプではなかった場合のエラー
//	define("ERR_NOT_IMG_MIME_TYPE", "画像はGIFまたはJPEG形式で用意してください。");
	define("ERR_NOT_IMG_MIME_TYPE", "画像はJPEG形式で用意してください。");

	//各種項目配列
	//エリア名
	$AREA = array(1=>"北海道・東北","関東","北陸・甲信越","東海","近畿","中国","四国","九州・沖縄");
	$AREA_E = array(1=>"hokkaido_tohoku","kanto","hokuriku_koshinetsu","tokai","kinki","chugoku","shikoku","kyushu_okinawa");
	//都道府県
	$PREFECTURE = array(1=>"北海道", "青森県", "岩手県", "宮城県", "秋田県", "山形県", "福島県", "茨城県", "栃木県", "群馬県", "埼玉県", "千葉県", "東京都", "神奈川県", "新潟県", "富山県", "石川県", "福井県", "山梨県", "長野県", "岐阜県", "静岡県", "愛知県", "三重県", "滋賀県", "京都府", "大阪府", "兵庫県", "奈良県", "和歌山県", "鳥取県", "島根県", "岡山県", "広島県", "山口県", "徳島県", "香川県", "愛媛県", "高知県", "福岡県", "佐賀県", "長崎県", "熊本県", "大分県", "宮崎県", "鹿児島県", "沖縄県");
	$PREFECTURE_E = array(1=>"hokkaido","aomori","iwate","miyagi","akita","yamagata","fukushima","ibaraki","tochigi","gunma","saitama","chiba","tokyo","kanagawa","niigata","toyama","ishikawa","fukui","yamanashi","nagano","gifu","shizuoka","aichi","mie","shiga","kyoto","osaka","hyogo","nara","wakayama","tottori","shimane","okayama","hiroshima","yamaguchi","tokushima","kagawa","ehime","kochi","fukuoka","saga","nagasaki","kumamoto","oita","miyazaki","kagoshima","okinawa");

	//性別
	$SEX_ARY = array(1=>"男性", "女性");

	//学校の種類
	$SCHOOL_TYPE_ARY = array(1=>"通信制高校", "通信制サポート校", "技能連携校");

	//学校の種類
	$ESTABLISH_TYPE_ARY = array(1=>"公立", "私立");

	//通学頻度
	$SCHOOLING_LEVEL_ARY = array(1=>"週5日", "週1～3日", "月2日", "年3～6日", "フリー", "インターネット");

	//掲載契約の種類
	$CONTRACT_RANK_ARY = array("1"=>"フル有料", "5"=>"お試し", "10"=>"無料");

	//サイト内表示の種類
	$SHOW_MODE_ARY = array("1"=>"表示中", "0"=>"非表示");

	//資料請求者の種類
	$CLIENT_KIND = array("1"=>"本人", "保護者", "教育関係者", "その他");
	
	//制服の種類
	$UNIFORM_KIND = array("制服なし", "制服あり", "制服あり（私服も可）");
	
	//資料請求者の学年種類
	$GRADE_KIND = array("1"=>"中学1年", "中学2年", "中学3年", "高校1年", "高校2年", "高校3年", "その他");
	
	//曜日
	$dow_ary = array("日", "月", "火", "水", "木", "金", "土");

	//問合せの種類
	$contact_type = array(1=>"当サイトについて", "掲載学校情報について","その他");

	//最新情報ジャンル
	$NEWS_GENRE_ARY = array("info"=>"お知らせ","comic"=>"コミック", "game"=>"ゲーム", "movie"=>"動画", "pc"=>"パソコン", "another"=>"その他");
	
	//カリキュラム最大登録数
	$max_curric_cnt=7;

?>