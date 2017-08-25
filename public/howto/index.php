<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//sess.php を取り込む
include_once("./../inc/sess.php");

$PAGE_TITLE="失敗しない通信制高校の選び方";
$PAGE_DESCRIPTION="失敗しない通信制高校の選び方についてご紹介いたします。";
$PAGE_KEYWORDS="選び方,".SET_META_KEYWORDS_S;


	
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
				<h3>高校卒業の資格が欲しい理由は？</h3>
				<h4>何のために高卒資格が必要なのか入学前に考えてみましょう。</h4>
				<p>そうすると、あなたに合う通信制高校がより明確になります。</p>
				<ul class="smallList">
					<li>・友達が高校に通っているから</li>
					<li>・大学・短大、専門学校に進学したいから<li>
					<li>・求人条件に高卒以上が多いから<li>
					<li>・中卒では取れない資格があるから<li>
				</ul>
				<h3>「高等学校卒業程度認定試験」（高卒認定）に合格すれば高校卒業資格になりますか？</h3>
				<p>
					「高等学校卒業程度認定試験」に合格すると、「高校卒業と同程度の学力」が認定されたということになりますが、高校卒の学歴にはなりません。大学や専門学校の入学資格を得ることはできますが、もし不合格の場合、学歴は高校卒業ではなく中学卒業となります。
				</p>
				<h3>通信制高校・サポート校はどこでも同じ？</h3>
				<h4>通信制高校・サポート校は、学校ごと学習方法や校風は全く異なります。</h4>
				<p>
				なかには、入学したもののイメージと違うので退学する方もいます。そうならないためにも、いくつか学校を見比べることをおすすめしています。
				</p>
				<span class="title">おススメＰＯＩＮＴ</span>
				<ul class="smallList">
					<li>1）少なくとも2～3校は必ず見比べる</li>
					<li>2）直接足を運んで話を聞くら<li>
					<li>3）在校生の雰囲気を知るために授業見学をする<li>
				</ul>
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
