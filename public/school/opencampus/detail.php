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
//イベントID取得
$event_id = $_GET['event_id'];

$k_sql = "select DISTINCT * FROM mtb_school_event WHERE del_flag = '0' AND school_id = '$school_id' ";
$k_res = $mysqli->query($k_sql);
$k_cnt = $k_res->num_rows;

if($k_cnt==0){
	$k_err=1;
	$PAGE_TITLE=$school_name."イベントエラー";
	$PAGE_DESCRIPTION=$school_name."のイベント情報。";
	$PAGE_KEYWORDS=$school_name.",オープンキャンパス,説明会,通信制高校";
}else{
	$k_data = $k_res->fetch_assoc();
	$PAGE_TITLE=$k_data[event_title]."|".$school_name;
	$PAGE_DESCRIPTION=$school_name."の".$k_data[event_title]."のご案内。";
	$PAGE_KEYWORDS=$school_name.",オープンキャンパス,説明会,通信制高校";
	
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
			<a href="/">ホーム</a>&nbsp;&gt;&nbsp;<a href="./../"><?=$school_name?></a>&nbsp;&gt;&nbsp;<a href="./">オープンキャンパス/説明会</a>&nbsp;&gt;&nbsp;<?=$k_data[event_title]?>
		</div>
	<?if($err==1){?>
		<article id="main_box">
			<p>申し訳ございません。こちらのIDの学校は、登録が無いか現在表示が出来ません。</p>
			<p><a href="/search/">学校検索画面に戻る</a></p>
		</article>
	<?}elseif($k_err==1){?>
		<article id="main_box">
			<p>申し訳ございません。こちらのIDのイベントは、登録が無いか現在表示が出来ません。</p>
			<p><a href="./">オープンキャンパス/説明会一覧に戻る</a></p>
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
				<h3>オープンキャンパス/説明会</h3>
				<div>
					<article class="curriculum">
						<h4><?=$k_data[event_title]?></h4>
						<p><?=nl2br($k_data[event_text])?></p>
					</article>
					<div class="entry_box">
						<div>
							<?if($evt_cnt>0){?>
							<a href="/entry_event.html?event_id=<?=$k_data[event_id]?>" class="ev_entry_btn2">オープンキャンパス/説明会に申し込む</a>
							<?}?>
						</div>
					</div>
					<div class="back2link"><a href="./">一覧に戻る</a></div>
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
