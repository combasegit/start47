<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//teacher_sess.php を取り込む
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
						<div class="ttl">お知らせ</div>
						<div class="con">
							<p class="fs11"></p>
							<table>
								<tr>
									<th>日付</th>
									<th>内容</th>
								</tr>
								<tr>
									<td>2016/07/06</td>
									<td>「課題管理」新規課題作成時に提出期限の設定が可能になりました。</td>
								</tr>
								<tr>
									<td>2016/07/07</td>
									<td>「宿題管理」機能を閉鎖しました。（「課題管理」に期限設定が搭載されたので、機能統合しました）</td>
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