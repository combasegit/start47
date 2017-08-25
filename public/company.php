<?
//inc.php を取り込む
include_once("./inc/inc.php");
//sess.php を取り込む
include_once("./inc/sess.php");
//画像アップフォルダ
$uploaddir = './school_img/';
$uploaddir2 = '/school_img/';

$PAGE_TITLE="運営会社";
$PAGE_DESCRIPTION="当サイトの運営会社について、ご案内いたします。";
$PAGE_KEYWORDS="運営会社,".SET_META_KEYWORDS_S;


	
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
				<table class="search_box">
					<tr>
						<th><span class="ttl">会社名</span></th>
						<td>株式会社アクセル</td>
					</tr>
					<tr>
						<th><span class="ttl">設立</span></th>
						<td>平成6年6月</td>
					</tr>
					<tr>
						<th><span class="ttl">代表者</span></th>
						<td>代表取締役　元柏雅博</td>
					</tr>
					<tr>
						<th><span class="ttl">本社</span></th>
						<td>〒142-0063　東京都品川区荏原3-1-4-2Ｆ</td>
					</tr>
					<tr>
						<th><span class="ttl">事業内容</span></th>
						<td>通信制高校向け／大学院向け／大学向け／専門学校向け／日本語学校向け／学生募集支援サービスエージェンシー、コンサルティングサービス</td>
					</tr>
				</table>
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
