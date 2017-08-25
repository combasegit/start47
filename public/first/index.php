<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//sess.php を取り込む
include_once("./../inc/sess.php");

$PAGE_TITLE="初めての方へ";
$PAGE_DESCRIPTION="当サイトのご利用方法をご案内いたします。";
$PAGE_KEYWORDS="利用方法,".SET_META_KEYWORDS_S;


	
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
				<p>ようこそ、「通信制高校からはじめよう-START47.COM-」へ♪<br />
				当サイトでは、通信制高校への入学を考えている方や、その保護者の方に「通信制高校」の正しい知識・情報をご提供すると共に、その方にとって最適な通信制高校選びをお手伝いする事を目標に運営をしております。</p>
				<h3>まず、今のあなたの状態を整理してみましょう</h3>
				<img src="../img/chart.jpg" alt="" style="margin-top:15px;" class="sp_img">
				<p>様々な理由から、「通信制高校に行きたいっ！」と思っていらっしゃる方も多いと思います。でも、ちょっと待って！漠然とした気持ちだけでの学校選びは、大変危険です！！より良い環境選びとしての進学が、悲惨な結果に・・・なんて事にならないように、まずは「今の自分」をもう一度見直してみませんか？その上で、自分にとっての最適な学校ってどんな学校なのか、一緒に探してみませんか？</p>
				⇒<a href="./relieve_concern.html">不安を一緒に解決しましょう</a>
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
