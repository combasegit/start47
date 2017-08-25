<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//sess.php を取り込む
include_once("./../inc/sess.php");

$PAGE_TITLE="よくあるご質問";
$PAGE_DESCRIPTION="当サイトのご利用に関しまして、よくあるご質問とその回答についてご紹介いたします。";
$PAGE_KEYWORDS="Ｑ＆Ａ,質問,".SET_META_KEYWORDS_S;


	
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
			<a href="/"><?=SET_SITE_TITLE_S?>TOP</a>&nbsp;&gt;&nbsp;<a href="./">Ｑ＆Ａ・お問合せ</a>&nbsp;&gt;&nbsp;<?=$PAGE_TITLE?>
		</div>
		<article id="main_box">
			<div id="search_title_box">
				<h2><?=$PAGE_TITLE?></h2>
			</div>
			<section class="contents_txt">
				<p>当サイトのご利用や通信制高校進学に関しまして、よくあるご質問とその回答をまとめています。こちらに無いご質問や更に深いご相談等がある場合には、通信制高校に関する事でしたら『<a href="/concierge/">進学コンシェルジュ</a>』、当サイトに関する事でしたら『<a href="./contact.html">お問合せ</a>』よりお願いいたします。</p>
				<div class="faq_f_lst_box">
					<div class="ttl">ご質問リスト</div>
					<ul>
						<li><a href="#ans1">Q1：通学している（通学していた）高校の単位は引き継げますか？</a></li>
						<li><a href="#ans1">Q2：成績が低いのですが入学できますか？</a></li>
						<li><a href="#ans1">Q3：欠席が多く不登校傾向だったのですが？</a></li>
					</ul>
				</div>
				<div class="faq_a_lst_box">
					<article id="ans1">
						<h3>Q1：通学している（通学していた）高校の単位は引き継げますか？</h3>
						<section>
							引き継ぐことができます。在籍していた高校の在籍期間や単位取得状況により違いがあります。通信制高校では、丁寧に手続きをサポートしてくれるので安心してご相談ください。
						</section>
					</article>
					<article id="ans2">
						<h3>Q2：成績が低いのですが入学できますか？</h3>
						<section>
							通信制高校では、出欠日数や成績だけで合格、不合格を判定することはありません。各校とも、面接や入学に対する本人のやる気、気持ちを重視しています。また、様々な状況にも対応できるよう配慮されているので、安心してご相談ください。
						</section>
					</article>
					<article id="ans3">
						<h3>Q3：欠席が多く不登校傾向だったのですが？</h3>
						<section>
							通信制高校は、多様な状況の生徒に対して、無理のない学習方法、登校日数、登校支援や放課後指導等、親身にサポートしています。ですからあなたのペースで成長していくことができます。
						</section>
					</article>

				</div>
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
