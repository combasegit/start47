<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//teacher_sess.php を取り込む
include_once("./../inc/admin_sess.php");
//ページ名
$PAGE_TITLE = "ダッシュボード";


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
	<div id="wrapper">
<?
//ヘッダー を取り込む
include_once("./00_header.php");
?>
		<div id="middle">
<?
//MENU を取り込む
include_once("./00_menu.php");
?>
			<div id="right_main">
				<div id="breadcrumb">
					<a href="./main.php">HOME</a>　>　
					<a href="#"><?=$PAGE_TITLE?></a>
				</div>
				<div id="main_box">
					<div class="data_box2 clearfix">
						<div class="ttl">サイトデータサマリー</div>
						<div class="con">
							<p class="fs11"></p>
							<table>
								<tr>
									<th colspan="<?=count($SCHOOL_TYPE_ARY)+2?>">学校登録状況</th>
								</tr>
								<tr>
									<th>学校種別</th>
								<?
									foreach($SCHOOL_TYPE_ARY AS $k=>$val){
								?>
									<th><?=$val?></th>
								<?}?>
									<th>合計</th>
								</tr>
								<tr>
									<th>有料掲載</th>
								<?
									foreach($SCHOOL_TYPE_ARY AS $k=>$val){
								?>
									<td style="text-align:right;"><?=$k?></td>
								<?}?>
									<td style="text-align:right;"><?=$sum?></td>
								</tr>
								<tr>
									<th>無料掲載</th>
								<?
									foreach($SCHOOL_TYPE_ARY AS $k=>$val){
								?>
									<td style="text-align:right;"><?=$k?></td>
								<?}?>
									<td style="text-align:right;"><?=$sum?></td>
								</tr>
								<tr>
									<th>計</th>
								<?
									foreach($SCHOOL_TYPE_ARY AS $k=>$val){
								?>
									<td style="text-align:right;"><?=$k?></td>
								<?}?>
									<td style="text-align:right;"><?=$sum?></td>
								</tr>
							</table>
						</div>
					</div>


					<br style="clear:left;" />
				</div>
			</div>
		</div>
<?
//フッター を取り込む
include_once("./00_footer.php");
?>
	</div>
</body>
</html>