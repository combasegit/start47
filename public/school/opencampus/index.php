<?
//inc.php を取り込む
include_once("./../../inc/inc.php");
//sess.php を取り込む
include_once("./../../inc/sess.php");
$mode="";
if($_GET['prev']==1){
	$mode="preview";
}
//本日の日付
$today_date = date("Y-m-d");

//00_school_data.php を取り込む
include_once("./../00_school_data.php");
//メタ情報
$PAGE_TITLE=$school_name."オープンキャンパス/説明会情報";
$PAGE_DESCRIPTION=$school_name."のオープンキャンパスや説明会の情報をご案内いたします。";
$PAGE_KEYWORDS=$school_name.",オープンキャンパス,説明会,通信制高校";

$k_sql = "select DISTINCT m.* FROM mtb_school_event AS m, dtb_event_date AS d WHERE m.del_flag = '0' AND m.event_id = d.event_id AND m.school_id = '$school_id' AND d.event_date >= '$today_date' ";
$k_res = $mysqli->query($k_sql);
$k_cnt = $k_res->num_rows;
#echo $k_sql;

$d_sql = "select d.*, date_format(d.event_date, '%c/%e') AS event_date2, date_format(d.event_date, '%w') AS youb FROM dtb_event_date AS d, mtb_school_event AS m WHERE m.school_id = '$school_id' AND m.event_id = d.event_id AND d.event_date >= '$today_date' ";
$d_res = $mysqli->query($d_sql);#echo $d_sql;
while($d_data = $d_res->fetch_assoc()){
	$EVENT_DATE_LIST[$d_data['event_id']][]=$d_data['event_date2']."(".$dow_ary[$d_data['youb']].")";
}

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
			<a href="/">ホーム</a>&nbsp;&gt;&nbsp;<a href="./../"><?=$school_name?></a>&nbsp;&gt;&nbsp;<?=$PAGE_TITLE?>
		</div>
	<?if($err==1){?>
		<article id="main_box">
			<p>申し訳ございません。こちらのIDの学校は、登録が無いか現在表示が出来ません。</p>
			<p><a href="/search/">学校検索画面に戻る</a></p>
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
			<article id="detail_box">
				<h3>オープンキャンパス/説明会情報</h3>
				<div id="news_lst" style="margin-top:0px;">
					<div class="ttl_box">
							<div class="ttl_data">開催日</div>
							<div class="ttl_content">イベント名</div>
					</div>
					<?
					while($k_data = $k_res->fetch_assoc()){
					?>
					<article>
						<a href="./detail_<?=$k_data[event_id]?>.html">
							<div class="event_data">
								<div class="date">
									<?foreach($EVENT_DATE_LIST[$k_data[event_id]] as $tmp){?>
										<?=$tmp?>　
									<?}?>
								</div>
							</div>
							<div class="event_content">
								<div class="ttl"><?=$k_data[event_title]?></div>
							</div>
						</a>
					</article>
					<?}?>
				</div>
			</article>
			<?if($contract_rank!="10"){?>
			<div id="many_from_box">入学者が多い地域：<?=$many_from?></div>
<?
//00_detail_link_box.php を取り込む
include_once("./../00_detail_link_box.php");
?>
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
