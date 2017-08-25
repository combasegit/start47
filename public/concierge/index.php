<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//sess.php を取り込む
include_once("./../inc/sess.php");

$PAGE_TITLE="進学コンシェルジュ";
$PAGE_DESCRIPTION="進学コンシェルジュサービスのご利用方法をご案内いたします。";
$PAGE_KEYWORDS="進学,コンシェルジュ,".SET_META_KEYWORDS_S;

	
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<?
//メタ情報 を取り込む
include_once("./../00_meta.php");
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
include_once("./../00_header.php");
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
				<h3>その悩み、進学コンシェルジュにお任せください！</h3>
				<p>通信制高校進学に対する漠然とした不安から、学校選択に対する悩み、或いは志望する学校に関しての質問など、一般的なホームページやパンフレットだけでは分かりづらい事柄やちょっと人には質問しづらい事。・・・そんな時は、ぜひ当サイトの<strong>進学コンシェルジュ</strong>にご相談ください♪</p>
				<a href="./ask.html" class="btn_entry">進学コンシェルジュに相談する<a>
			</section>
		</article>
<?
//サイドパーツ を取り込む
include_once("./../00_aside.php");
?>
	</main>
<?
//フッターパーツ を取り込む
include_once("./../00_footer.php");
?>
</body>
</html>
