<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//sess.php を取り込む
include_once("./../inc/sess.php");
$mode="";
if($_GET['prev']==1){
	$mode="preview";
}
//学校詳細用MENUトップフラグ
$sc_top_flag=1;
//00_school_data.php を取り込む
include_once("./00_school_data.php");
//メタ情報
$PAGE_TITLE=$school_name;
$PAGE_DESCRIPTION=$school_name."の詳細情報です。";
$PAGE_KEYWORDS=$school_name.",通信制高校";

?>
<!DOCTYPE html>
<html lang="ja">
</head>
<body>
<?
//メタ情報 を取り込む
include_once("./../00_meta.php");
?>
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
			<a href="/">ホーム</a>&nbsp;&gt;&nbsp;<a href="/search/">学校を探す</a>&nbsp;&gt;&nbsp;<a href="/search/<?=$AREA_E[$THIS_SCHOOL_AREA]?>/"><?=$AREA[$THIS_SCHOOL_AREA]?></a>&nbsp;&gt;&nbsp;<a href="/search/<?=$AREA_E[$THIS_SCHOOL_AREA]?>/<?=$PREFECTURE_E[$THIS_SCHOOL_PREF]?>/"><?=$PREFECTURE[$THIS_SCHOOL_PREF]?></a>&nbsp;&gt;&nbsp;<a href="./"><?=$school_name?></a>
		</div>
	<?if($err==1){?>
		<article id="main_box">
			<p>申し訳ございません。こちらのIDの学校は、登録が無いか現在表示が出来ません。</p>
			<p><a href="/search/">学校検索画面に戻る</a></p>
		</article>
	<?}else{?>
		<article id="main_box">
			<div id="sc_detail">
				<div class="top_head"><img src="<?=$top_head_path?>" alt="<?=$school_name?>TOP画像" /></div>
				<div class="thumb_img only_pc"><img src="<?=$thumb_path?>" alt="<?=$school_name?>" /></div>
				<div class="sc_type_box">
					<div class="establish_type"><?=$ESTABLISH_TYPE_ARY[$establish_type]?></div>
					<div class="scool_type"><?=$SCHOOL_TYPE_ARY[$school_type]?></div>
				</div>
				<h2 class="h2_min_ind"><?=$school_name?></h2>
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
<?
//00_detail_link_box.php を取り込む
include_once("./00_detail_link_box.php");
?>
			<div id="catch_box">
				<div class="copy"><?=$catch_copy?></div>
				<p><?=nl2br($pr_txt)?></p>
			</div>
			<?if($contract_rank!="10"&&$n_cnt>0){?>
			<div id="sc_top_box">
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
									<div class="date"><?=$n_date_ary[0]?>年 <?=$n_date_ary[1]?>月<?=$n_date_ary[2]?>日</div>
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
			</div>
			<?}?>
			<div id="many_from_box">入学者が多い地域：<?=$many_from?></div>
<?
//00_entry_box.php を取り込む
include("./00_entry_box.php");
?>
			<div id="sc_top_summary">
				<?if(is_array($schooling_level)||strlen($schooling_level_memo)){?>
				<div class="data_box">
					<h3>登校</h3>
					<?if(is_array($schooling_level)){?>
					<div class="class_data">
						<div class="ttl">登校頻度</div>
						<div class="con"><?foreach($schooling_level as $sl){echo "・".$SCHOOLING_LEVEL_ARY[$sl]."　" ;}?></div>
					</div>
					<?}?>
					<?if(strlen($schooling_level_memo)){?>
					<div class="class_data">
						<div class="ttl">補足</div>
						<div class="con"><?=$schooling_level_memo?></div>
					</div>
					<?}?>
				</div>
				<?}?>
				<?if(($class_students>0)||($rate_men>0)||($rate_women>0)||strlen($rate_memo)){?>
				<div class="data_box">
					<h3>クラス人数</h3>
					<?if($class_students>0){?>
					<div class="class_data">
						<div class="ttl">１クラス</div>
						<div class="con">約<?=$class_students?>人</div>
					</div>
					<?}?>
					<?if($rate_men>0){?>
					<div class="class_data">
						<div class="ttl">男女比</div>
						<div class="con">男性<?=$rate_men?>：女性<?=$rate_women?></div>
					</div>
					<?}?>
					<?if(strlen($rate_memo)){?>
					<div class="class_data">
						<div class="ttl">補足</div>
						<div class="con"><?=$rate_memo?></div>
					</div>
					<?}?>
				</div>
				<?}?>
				<div class="data_box">
					<h3>所在地</h3>
					<?foreach($CAMPUS_DATA as $c=>$val){?>
					<table class="campus_data">
						<tr>
							<th colspan="2"><?=$val[campus_name]?></th>
						</tr>
						<?if(strlen($val[pref])||strlen($val[address])){?>
						<tr>
							<th>所在地</th>
							<td>〒<?=$val[zip1]?>-<?=$val[zip2]?> <?=$PREFECTURE[$val[pref]]?><?=$val[address]?></td>
						</tr>
						<?}?>
						<?if(strlen($val[tel])){?>
						<tr>
							<th>電　話</th>
							<td><?=$val[tel]?></td>
						</tr>
						<?}?>
						<?if(strlen($val[access])){?>
						<tr>
							<th>アクセス</th>
							<td><?=$val[access]?></td>
						</tr>
						<?}?>
					</table>
					<?}?>
				</div>
			</div>
			<?if($contract_rank!="10"){?>
<?
//00_entry_box.php を取り込む
include("./00_entry_box.php");
?>
<div class="only_pc">
<?
//act_box を取り込む
include("./00_act_box.php");
?>
</div>
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
