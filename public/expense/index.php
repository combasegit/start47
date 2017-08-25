<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//sess.php を取り込む
include_once("./../inc/sess.php");

$PAGE_TITLE="通信制高校の学費について";
$PAGE_DESCRIPTION="通信制高校の学費についてご紹介いたします。";
$PAGE_KEYWORDS="学費,".SET_META_KEYWORDS_S;


	
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
				<h3>学費の違いについて</h3>
				<h4>通信制高校も全日制高校と同様、学費が必要です。</h4>
				<p>
					全日制高校と同様、公立高校の学費は安く、私立高校の学費が高くなっています。公立高校の場合、都道府県により学費は異なります。私立高校の場合は、設置者により学費に差があります。私立の通信制高校、通信サポート校の場合、スクーリング費や施設設備費などの諸経費などがかかるのが一般的です。
					<br />通信制高校の学費の考え方は、1単位あたりいくらです。卒業までに74単位必要ですので、1単位あたりの単価×74が学費となります。公立高校の場合、入学金は500～1000円程度。授業料は、1単位あたり500～1,000円程度です。私立高校の場合、入学金は2万円～10万円程度。授業料は1単位あたり、8,000円～10,000円程度です。学習環境、通学頻度、高校卒業までの支援体制などをお確かめください。
				</p>
				<h3>学費の分納はできますか？</h3>
				<h4>入学金は入学時に、授業料は学年の初年度までに一括で納入するのが一般的です。</h4>
				<p>
					学校によっては、分納に応じている学校もあるようです。最新の情報は、入学をお考えの通信制高校でお確かめください。
				</p>
				<h3>奨学金制度はありますか？</h3>
				<p>
					就学支援金／文部科学省による「高等学校等就学支援金制度(以下就学支援金)」により、保護者の所得(課税額)に応じて「就学支援金」が支給されます。 その他学校ごとに授業料の減免制度を設けている場合があります。最新の情報は、入学をお考えの通信制高校でお確かめください。
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
