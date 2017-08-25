<?
//inc.php を取り込む
include_once("./../../inc/inc.php");
//sess.php を取り込む
include_once("./../../inc/sess.php");
$mode="";
if($_GET['prev']==1){
	$mode="preview";
}

//00_school_data.php を取り込む
include_once("./../00_school_data.php");
//お知らせID取得
$news_id = $_GET['news_id'];

$ns_sql = "select *, date_format(news_date, '%Y年%m月%d日') AS news_date2 from dtb_school_news where school_id = '$school_id' AND del_flag = '0' AND news_id = '$news_id' ";
$ns_res = $mysqli->query($ns_sql);
$ns_cnt = $ns_res->num_rows;

if($ns_cnt==0){
	$ns_err=1;
	$PAGE_TITLE=$school_name."お知らせエラー";
	$PAGE_DESCRIPTION=$school_name."からのお知らせ。";
	$PAGE_KEYWORDS=$school_name.",お知らせ,ニュース,通信制高校";
	$ns_data[news_date]="0000-00-00";
}else{
	$ns_data = $ns_res->fetch_assoc();
	$PAGE_TITLE=$ns_data[news_title]."[".$ns_data[news_date2]."]".$school_name;
	$PAGE_DESCRIPTION=$ns_data[news_date2].$school_name."からのお知らせ。";
	$PAGE_KEYWORDS=$school_name.",".$ns_data[news_date2].",お知らせ,ニュース,通信制高校";
	
}

//メタ情報

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<?
//メタ情報 を取り込む
include_once("./../../00_meta.php");
?>
</head>
<body>
<?if($mode=="preview"){?>
<script>
$(function () {
	$('a[href]').click(function(e){e.preventDefault()}).attr('href','#');
	$('input:button,button,input:submit').attr('disabled', true);
});
</script>
<div id="prev">プレビュー表示中です、リンク＆ボタンは動作しません。</div>
<?}?>
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
include_once("./../../00_header.php");
?>
	<main>
		<div class="bread_list">
			<a href="/">ホーム</a>&nbsp;&gt;&nbsp;<a href="./../"><?=$school_name?></a>&nbsp;&gt;&nbsp;<a href="./">お知らせ一覧</a>&nbsp;&gt;&nbsp;[<?=$ns_data[news_date2]?>]<?=$ns_data[news_title]?>
		</div>
	<?if($err==1){?>
		<article id="main_box">
			<p>申し訳ございません。こちらのIDの学校は、登録が無いか現在表示が出来ません。</p>
			<p><a href="/search/">学校検索画面に戻る</a></p>
		</article>
	<?}elseif($ns_err==1){?>
		<article id="main_box">
			<p>申し訳ございません。こちらのIDの記事は、登録が無いか現在表示が出来ません。</p>
			<p><a href="./">お知らせ一覧に戻る</a></p>
		</article>
	<?}else{?>
		<article id="main_box">
			<div id="sc_detail">
				<div class="thumb_img2"><img src="<?=$thumb_path?>" alt="<?=$school_name?>" /></div>
				<div class="sc_type_box2">
					<div class="establish_type"><?=$ESTABLISH_TYPE_ARY[$establish_type]?></div>
					<div class="scool_type"><?=$SCHOOL_TYPE_ARY[$school_type]?></div>
				</div>
				<h2<?if($sc_name_cnt>20){echo " class=\"h2_min\"";}?>><?=$school_name?></h2>
<?
//act_box を取り込む
include("./../00_act_box.php");
?>
				<div class="feature_icons">
					<img src="/img/feature_icon/uniform<?=$uniform?>.png" alt="<?if($uniform==1){?>制服あり<?}elseif($uniform==1){?>制服なし<?}else{?>制服あり（私服も可）<?}?>" />
					<?if(0){?><img src="/img/feature_icon/schooling_lv<?=$schooling_level?>.png" alt="<?=$SCHOOLING_LEVEL_ARY[$schooling_level]?>" /><?}?>
					<?if(is_array($schooling_level)){foreach($schooling_level as $sl){?>
						<img src="/img/feature_icon/schooling_lv<?=$sl?>.png" alt="<?=$SCHOOLING_LEVEL_ARY[$sl]?>" />
					<?}}?>
				</div>
			</div>
<?
//00_detail_link_box.php を取り込む
include_once("./../00_detail_link_box.php");
?>
			<article id="detail_box">
				<h3>お知らせ</h3>
				<div>
					<article class="curriculum">
						<p class="news_date"><?=$ns_data[news_date2]?></p>
						<h4><?=$ns_data[news_title]?></h4>
						<p><?=nl2br($ns_data[news_text])?></p>
					</article>
					<div class="back2link"><a href="./">お知らせ一覧に戻る</a></div>
				</div>
			</article>
			<?if($contract_rank!="10"){?>
			<div id="many_from_box">入学者が多い地域：<?=$many_from?></div>
<?
//00_entry_box.php を取り込む
include("./../00_entry_box.php");
?>
			<?}?>
		</article>
	<?}?>
<?
//サイドパーツ を取り込む
include_once("./../../00_aside.php");
?>
	</main>
<?
//フッターパーツ を取り込む
include_once("./../../00_footer.php");
?>
</body>
</html>
