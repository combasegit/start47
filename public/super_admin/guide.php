<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//teacher_sess.php を取り込む
include_once("./../inc/teacher_sess.php");
//ページ名
$PAGE_TITLE = "推奨環境";


?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,user-scalable=no,maximum-scale=1" />
<title><?=$PAGE_TITLE?>|<?=SET_SITE_TITLE?></title>
<meta name="keywords" content="">
<meta name="description" content="">
<link rel="shortcut icon" href="/img/icon/favicon.ico" type="image/x-icon" />
<link rel="icon" href="/img/icon/favicon.ico" type="image/x-icon" />
<link rel="apple-touch-icon" href="/img/icon/webclip.png" />
<link rel="stylesheet" media="all" type="text/css" href="./css/main.css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
<script type="text/javascript" src="./js/jquery.cookie.js"></script>
<link rel="stylesheet" type="text/css" href="/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript" src="/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="./js/main.js"></script>
</head>
<body>
	<div id="wrapper">
<?
//ヘッダー を取り込む
include_once("./00_header.php");
?>
		<div id="middle">
<?
//MENU を取り込む
include_once("./00_menu.php");
?>
			<div id="right_main">
				<div id="breadcrumb">
					<a href="./main.php">HOME</a>　>　
					<a href="#"><?=$PAGE_TITLE?></a>
				</div>
				<div id="main_box">
					<div class="contents_box">
						<h2><?=$PAGE_TITLE?></h2>
						<div class="con">
							<p>FE試験授業支援システム（以下、「本システム」といいます）を快適にご利用いただく為に、インターネットに接続可能なパソコンと下記の条件を満たした環境をおすすめ致します。これ以外の環境でご利用いただいた場合、本システムの利用に必要な機能が使用できず、画面が正常に表示されない、動作しない等の現象が起きることがあります。</p>
							<div class="txt_unit">
								<div class="ttl">PCの推奨OSおよびブラウザ</div>
								<p>
									【Windows(VISTA以降)をお使いの場合】<br />
									　　１．Microsoft Internet Explorer 8.0以降<br />
									　　２．Mozilla Firefox 最新版<br />
									　　３．Google Chrome 最新版<br />
									　　※ブラウザの自動アップデート機能が有効になっていない場合は、最新版へのアップデートを推奨します。<br />
									　　※Internet Explorer10に関しては、動作確認はしておりますがページによっては正しく表示されない場合があります。<br /><br />
									【Macintosh(Mac OSX 10.6以降)をお使いの場合】<br />
									　　１．safari 5.x以降<br />
									　　２．Mozilla Firefox 最新版<br />
									　　３．Google Chrome 最新版<br />
									　　※ブラウザの自動アップデート機能が有効になっていない場合は、最新版へのアップデートを推奨します。
								</p>
							</div>
							<div class="txt_unit">
								<div class="ttl">必要な機能</div>
								<p>本システムでは、Http-Cookie(クッキー) 、JavaScript、およびスタイルシ－トを使用しております。ブラウザの設定でこれらの機能を有効にした上でご利用いただきますようお願いいたします。ブラウザの設定により、これらの機能を無効にした場合には、本システムの一部の機能をご利用いただけない場合があります。</p>
							</div>
							<div class="txt_unit">
								<div class="ttl">Http-Cookie(クッキー) について</div>
								<p>
									本システム内の一部のペ－ジにおいて、以下の目的でクッキーを使用することがあります。<br />
									　　１．管理画面表示の個別カスタマイズ設定保存の為、個人が特定できない状態で、お客様の表示状態を保存する目的<br />
									　　２．管理画面ログイン処理を容易にする為、次回利用時に引き継ぐ目的<br /><br />
									※クッキーとは当社のサ－バ－からお客様のブラウザに送信され、お客様のパソコンのハ－ドディスクに保存されるデ－タで、お客様を識別するための仕組みのことです。本システムのクッキーを使用したページへアクセスすると、お客様が入力または選択した情報がクッキ－に保存され、次回からそのクッキ－によりお客様が識別されます。<br /><br />
									お客様は、ブラウザの設定により、クッキーの使用を制限する事ができますが、クッキーを無効にした場合には、本システムの一部のサ－ビスをご利用いただけない場合があります。
								</p>
							</div>
						</div>
						<div class="submit_box"></div>
					</div>
				</div>
			</div>
		</div>
<?
//フッター を取り込む
include_once("./00_footer.php");
?>
	</div>
</body>
</html>