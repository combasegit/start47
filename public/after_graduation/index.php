<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//sess.php を取り込む
include_once("./../inc/sess.php");

$PAGE_TITLE="卒業後について";
$PAGE_DESCRIPTION="通信制高校の卒業後についてご紹介いたします。";
$PAGE_KEYWORDS="卒業,進路,就職,".SET_META_KEYWORDS_S;

	
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
				<h3>ちゃんと卒業できる？</h3>
				<h4>通信制高校に留年はありません！</h4>
				<p>
					通信制高校は主に単位制高校です。3年間で74単位を取得できれば高校卒業資格を取得できるので、単位不足で留年するということはありません。卒業の条件は以下の3つです。
					<br />・3年間以上の在籍（新卒者の場合）
					<br />・74単位の修得
					<br />・特別活動30単位の取得
				</p>
				<h3>進路指導はしてくれますか？</h3>
				<h4>ほとんどの通信制高校が進路指導をしています。</h4>
				<p>
					大学や短大、専門学校などへ進学実績の多い学校もあります。将来高校卒業後に進みたい分野があれば予めご相談することをおすすめします。
				</p>
				<h3>通信制高校の卒業について</h3>
				<p>
					全日制、定時制と同じ「高校卒業資格」となり、就職時も高校卒以上の求人に応募が可能となります。
				</p>

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
