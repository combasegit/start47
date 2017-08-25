<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//school_sess.php を取り込む
include_once("./../inc/school_sess.php");
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
						<div class="ttl">データサマリー</div>
						<div class="con">
							<p class="fs11"></p>
							<table>
								<tr>
									<th>資料請求数</th>
									<th></th>
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