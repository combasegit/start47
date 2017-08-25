<?
//inc.php を取り込む
include_once("./inc/inc.php");
//sess.php を取り込む
include_once("./inc/sess.php");
//画像アップフォルダ
$uploaddir = './school_img/';
$uploaddir2 = '/school_img/';

$PAGE_TITLE="当サイトについて";
$PAGE_DESCRIPTION="当サイトについて、ご案内いたします。";
$PAGE_KEYWORDS="推奨環境,".SET_META_KEYWORDS_S;

	
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<?
//メタ情報 を取り込む
include_once("./00_meta.php");
?>
</head>
<body>
<script>
(function($) {
    $(function() {
        var $header = $('#header_con');
        // Nav Toggle Button
        $('#nav-toggle').click(function(){
            $header.toggleClass('open');
        });
    });
})(jQuery);
</script>
<?
//ヘッダーパーツ を取り込む
include_once("./00_header.php");
?>
	<main>
		<div class="bread_list">
			<a href="/"><?=SET_SITE_TITLE_S?>TOP</a>&nbsp;&gt;&nbsp;<?=$PAGE_TITLE?>
		</div>
		<article id="main_box">
			<div id="search_title_box">
				<h2><?=$PAGE_TITLE?></h2>
			</div>
			<section class="contents_txt">
				<p>通信制高校からはじめよう(https://www.start47.com/ 以下、「当サイト」といいます)をご覧いただき誠にありがとうございます。当サイトを快適にご利用いただく為、下記をご確認ください。</p>
				<h3>推奨OS</h3>
				<p>以下のOSでご覧いただくことをお奨めいたします。 <br />Windows 7 以上<br />Macintosh OS X 以上</p>
				<h3>推奨ブラウザ</h3>
				<p>以下のブラウザでご覧いただくことをお奨めいたします。 <br />
					＜Windowsの場合＞ <br />
					　Internet Explorer 11以上<br />
					　Firefox 最新版<br />
					　Google Chrome最新版<br />
					　Microsoft Edge最新版（Windows10の場合）<br />
					＜Macintoshの場合＞ <br />
					　Safari 最新版<br />
					　Google Chrome最新版<br />
				</p>
				<h3>推奨解像度</h3>
				<p>スクリーンの解像度を 1024 X 768 ピクセル以上に設定してご覧いただくことをお奨めいたします。</p>
				<h3>Cookie(クッキー)</h3>
				<p>当サイトでは、サービスをご提供するために、クッキー(Cookie)を使用しています。クッキー(Cookie)とは、ホームページの訪問時において、ブラウザを通じてユーザーを識別するものであり、個人情報を特定するものではありません。ブラウザの設定でクッキー(Cookie)を無効にすることが可能ですが、当サイトの機能やサービスの一部がご利用になれない場合があります。あらかじめご了承ください。</p>
				<h3>JavaScript</h3>
				<p>当サイトでは、より快適にご利用いただくためJavaScriptを使用しているページがあります。JavaScriptを無効にされている場合、正しく機能しない場合があります。ご使用のブラウザ設定でJavaScriptを有効にしていただきますようお願いいたします(通常、初期値は有効になっています)。</p>
				<h3>CSS（Cascading Style Sheets）</h3>
				<p>当サイトでは、より快適に閲覧していただくためCSSを使用した表示設定を行っています。CSSを無効にされている場合(初期値は有効)、または、CSSに対応していないブラウザでご覧になっている場合は、正しく表示されない場合があります。あらかじめご了承ください。</p>
				<h3>セキュリティ</h3>
				<p>当サイトのWebサーバーとお客さまがお使いのブラウザとの間の情報が暗号化通信されている事を証明する「RapidSSL」SSLサーバー証明書(ジオトラスト社)を取得しています。これにより、SSL(Secure Socket Layer)が適用され、当サイトで個人情報を取り扱う「https」で始まるページで、お客様が入力された個人情報は、暗号化されて通信されます。</p>
				<h3>個人情報の保護について</h3>
				<p>「<a href="/privacy.html">個人情報保護方針</a>」をご覧ください。</p>
			</section>
		</article>
<?
//サイドパーツ を取り込む
include_once("./00_aside.php");
?>
	</main>
<?
//フッターパーツ を取り込む
include_once("./00_footer.php");
?>
</body>
</html>
