<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//sess.php を取り込む
include_once("./../inc/sess.php");
//メタ情報
$PAGE_TITLE="通信制高校を検索する";
$PAGE_DESCRIPTION="地域や都道府県、学校の種類や、制服のある・なし、登校頻度などの条件から通信制高校を検索できます。";
$PAGE_KEYWORDS="検索,通信制高校,制服,登校";

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

//ロード時
$(function(){
		var aid = $("#area_id option:selected").val();
		jQuery . ajax(
			'./pref_data_back.php',
			{
				data: {
					area_id: aid
				},
				success: function( data ) {
					jQuery( '#pref_data_box' ) . html( data );
				},
			}
		);
});

$(function(){
	$("#area_id").change(function(){
		var aid = $("#area_id option:selected").val();
		jQuery . ajax(
			'./pref_data_back.php',
			{
				data: {
					area_id: aid
				},
				success: function( data ) {
					jQuery( '#pref_data_box' ) . html( data );
				},
			}
		);
	});
});
</script>
<?
//ヘッダーパーツ を取り込む
include_once("./../00_header.php");
?>
	<main>
		<div class="bread_list">
			<a href="/"><?=SET_SITE_TITLE_S?>TOP</a>&nbsp;&gt;&nbsp;学校を探す
		</div>
		<article id="main_box">
			<div id="search_title_box">
				<h2>通信制高校を探す</h2>
			</div>
			<section>
				<p style="text-align:left;margin-left:10px;">あなたにあった学校を探してみよう♪</p>
				<form action="./result.html" method="GET" name="search_form">
				<table class="search_box">
					<tr>
						<th>地域</th>
						<td>
							<div class="select-box01">
								<select name="area_id" id="area_id">
									<option value="">選択</option>
									<?foreach($AREA as $k=>$val){?>
									<option value="<?=$k?>"><?=$val?></option>
									<?}?>
								</select>
							</div>
						</td>
					</tr>
					<tr>
						<th>都道府県</th>
						<td id="pref_data_box">
						</td>
					</tr>
					<tr>
						<th>学校の種類</th>
						<td>
							<div class="radio02">
								<input type="radio" id="st01" name="school_type" value="" class="radio02-input" />
								<label for="st01" class="radio"><span class="radio02-parts">すべて</span></label><br class="only_sp"/>
								<?foreach($SCHOOL_TYPE_ARY as $k=>$val){?>
								<input type="radio" id="st<?=$k?>" name="school_type" value="<?=$k?>" class="radio02-input" />
								<label for="st<?=$k?>" class="radio"><span class="radio02-parts"><?=$val?></span></label><br class="only_sp"/>
								<?}?>
							</div>
						</td>
					</tr>
					<tr>
						<th>制服</th>
						<td>
							<div class="radio02">
									<input type="radio" id="uc01" name="uniform_ck" value="" <?if($uniform_ck==""){echo "checked";}?> class="radio02-input" />
									<label for="uc01" class="radio"><span class="radio02-parts">どちらでも</span></label><br class="only_sp"/>
									<input type="radio" id="uc02" name="uniform_ck" value="1" <?if($uniform_ck==1){echo "checked";}?> class="radio02-input" />
									<label for="uc02" class="radio"><span class="radio02-parts">制服あり</span></label><br class="only_sp"/>
									<input type="radio" id="uc03" name="uniform_ck" value="2" <?if($uniform_ck==2){echo "checked";}?> class="radio02-input" />
									<label for="uc03" class="radio"><span class="radio02-parts">制服なし</span></label>
							</div>
						</td>
					</tr>
					<tr>
						<th>登校頻度</th>
						<td>
							<div class="checkbox02">
								<?foreach($SCHOOLING_LEVEL_ARY as $k=>$val){?>
								<label><input type="checkbox" name="schooling_level[]" value="<?=$k?>" <?if(in_array($k,$schooling_level)){echo "checked";}?> class="checkbox01-input" /><span class="checkbox01-parts"><?=$val?></span></label>　　<br class="only_sp"/>
							<?}?>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2" class="submit_box">
							<input type="submit" name="search" value="検索" class="submitBtn" />
						</td>
					</tr>
				</table>
				</form>
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
