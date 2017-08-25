<?
//inc.php を取り込む
include_once("./inc/inc.php");
//sess.php を取り込む
include_once("./inc/sess.php");

$PAGE_TITLE="学校からのお知らせ一覧";
$PAGE_DESCRIPTION="学校からのお知らせ一覧をご案内いたします。";
$PAGE_KEYWORDS="お知らせ,ニュース,".SET_META_KEYWORDS_S;

//お知らせ一覧取得
$n_sql = "select n.*, s.school_name from dtb_school_news as n, mtb_school as s where n.school_id = s.school_id AND n.del_flag = '0' AND s.del_flag = '0' ORDER BY n.news_date DESC ";
$n_res = $mysqli->query($n_sql);

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
				<div id="news_lst">
					<?
					while($n_data = $n_res->fetch_assoc()){
						$n_date_ary = explode('-',$n_data[news_date]);
					?>
					<article>
						<a href="/school/<?=$n_data[school_id]?>/news/detail_<?=$n_data[news_id]?>.html">
							<div class="news_data">
								<div class="date"><?=$n_date_ary[0]?>年<?=$n_date_ary[1]?>月<?=$n_date_ary[2]?>日</div>
								<div class="cate"><?=$n_data[school_name]?></div>
							</div>
							<div class="news_content">
								<div class="ttl"><?=$n_data[news_title]?></div>
								<p><?=$n_data[news_txt]?></p>
							</div>
						</a>
					</article>
					<?}?>
				</div>
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
