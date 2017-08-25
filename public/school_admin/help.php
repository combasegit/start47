<?
// inc.php を取り込む
include_once("./../inc/inc.php");
// セッション
include_once("./../inc/teacher_sess.php");

//help_id
$help_id = $_REQUEST[help_id];

if($help_id=="main"){
	$h1="管理画面の使い方";
	$content ="各管理機能ページ表示中にこのボタン（画面右上の「HELP」）を押していただくと、表示中の管理機能についてのご利用方法をご説明させていただきます。";
}elseif($help_id=="msg"){
	$h1="メッセージ確認管理";
	$content ="これまでに投稿されたメッセージの内容確認と編集・削除ができます。";
}else{
	$h1="Now Printing !";
	$content ="このページの説明は、現在作成中となります。今しばらくお待ちくださいm(__)m";
}


header("Content-type: text/html; charset=utf-8");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>HELP：<?=SET_SITE_NAME_S?></title>
<link rel="shortcut icon" href="/img/icon/favicon.ico" type="image/x-icon" />
<link rel="icon" href="/img/icon/favicon.ico" type="image/x-icon" />
<link href="css/help.css" rel="stylesheet" type="text/css" />
<script type="text/javascript"><!-- /*@cc_on _d=document;eval('var document=_d')@*/ --></script>
<script type="text/javascript" src="/js/main.js"></script>
</head>
<body>
	<div id="wrap">
		<div id="header">
			<h1><?=$h1?></h1>
		</div>
		<div id="main">
			<?=$content?>
		</div>
		<div id="footer"></div>
	</div>
</body>
</html>
