<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//sess.php を取り込む
include_once("./../inc/sess.php");
$mode="";
if($_GET['prev']==1){
	$mode="preview";
}

//00_school_data.php を取り込む
include_once("./00_school_data.php");
//メタ情報
$PAGE_TITLE=$school_name."学費";
$PAGE_DESCRIPTION=$school_name."の学費についてご案内いたします。";
$PAGE_KEYWORDS=$school_name.",学費,入学金,授業料,通信制高校";

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
include_once("./../00_header.php");
?>
	<main>
		<div class="bread_list">
			<a href="/">ホーム</a>&nbsp;&gt;&nbsp;<a href="/search/">学校を探す</a>&nbsp;&gt;&nbsp;<a href="/search/<?=$AREA_E[$THIS_SCHOOL_AREA]?>/"><?=$AREA[$THIS_SCHOOL_AREA]?></a>&nbsp;&gt;&nbsp;<a href="/search/<?=$AREA_E[$THIS_SCHOOL_AREA]?>/<?=$PREFECTURE_E[$THIS_SCHOOL_PREF]?>/"><?=$PREFECTURE[$THIS_SCHOOL_PREF]?></a>&nbsp;&gt;&nbsp;<a href="./"><?=$school_name?></a>&nbsp;&gt;&nbsp;学費
		</div>
	<?if($err==1){?>
		<article id="main_box">
			<p>申し訳ございません。こちらのIDの学校は、登録が無いか現在表示が出来ません。</p>
			<p><a href="/search/">学校検索画面に戻る</a></p>
		</article>
	<?}else{?>
		<article id="main_box">
			<div id="sc_detail">
				<div class="sc_type_box2">
					<div class="establish_type"><?=$ESTABLISH_TYPE_ARY[$establish_type]?></div>
					<div class="scool_type"><?=$SCHOOL_TYPE_ARY[$school_type]?></div>
				</div>
				<h2<?if($sc_name_cnt>20){echo " class=\"h2_min\"";}?>><?=$school_name?></h2>
<?
//act_box を取り込む
include("./00_act_box.php");
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
				<h3>学費</h3>
				<div class="data_box">
					<table class="campus_data">
						<tr>
							<th style="width:30%;">項目</th>
							<th style="width:70%;">金額</th>
						</tr>
						<tr>
							<th>入学金</th>
							<td style="text-align:right;"><?=$entrance_fee?></td>
						</tr>
						<tr>
							<th>授業料</th>
							<td style="text-align:right;"><?=$school_fee?></td>
						</tr>
						<tr>
							<th>教材費</th>
							<td style="text-align:right;"><?=$material_fee?></td>
						</tr>
						<tr>
							<th>施設費</th>
							<td style="text-align:right;"><?=$facility_fee?></td>
						</tr>
						<tr>
							<th style="border-bottom:2px solid #399CA6;">諸経費</th>
							<td style="text-align:right;border-bottom:2px solid #399CA6;"><?=$sundry_expenses?></td>
						</tr>
						<tr>
							<th>合計</th>
							<td style="text-align:right;"><?=$total_fee?></td>
						</tr>
					</table>
					<article class="curriculum">
						<h4>備考</h4>
						<p><?=nl2br($fee_note)?></p>
					</article>
				</div>
			</article>
			<?if($contract_rank!="10"){?>
			<div id="many_from_box">入学者が多い地域：<?=$many_from?></div>
<?
//00_detail_link_box.php を取り込む
include_once("./00_detail_link_box.php");
?>
<?
//00_entry_box.php を取り込む
include("./00_entry_box.php");
?>
			<?}?>
			<div id="sc_top_summary">
				<?if($contract_rank!="10"&&$n_cnt>0){?>
				<div class="data_box">
					<h3>お知らせ</h3>
					<a href="./news/" class="lnk2lst">一覧を見る</a>
					<div id="news_lst">
						<?
						while($n_data = $n_res->fetch_assoc()){
							$n_date_ary = explode('-',$n_data[news_date]);
						?>
						<article>
							<a href="./news/detail_<?=$n_data[news_id]?>.html">
								<div class="news_data">
									<div class="date"><?=$n_date_ary[0]?>年<br class="only_sp"/><?=$n_date_ary[1]?>月<?=$n_date_ary[2]?>日</div>
								</div>
								<div class="news_content">
									<div class="ttl"><?=$n_data[news_title]?></div>
									<p><?=$n_data[news_txt]?></p>
								</div>
							</a>
						</article>
						<?}?>
					</div>
				</div>
				<?}?>
<div class="only_pc">
<?
//act_box を取り込む
include("./00_act_box.php");
?>
</div>
			</div>
			<?if($contract_rank!="10"){?>
<?
//00_entry_box.php を取り込む
include("./00_entry_box.php");
?>
			<?}?>
		</article>
	<?}?>
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
