		<div id="footer">
			<div id="f_navi">
				<ul>
<?
	//ログインページ/フォゲットページでは以下非表示
	if(basename($_SERVER['PHP_SELF'])!="index.php" && basename($_SERVER['PHP_SELF'])!="forget.php"){
?>
					<li><a href="./main.php">ﾀﾞｯｼｭﾎﾞｰﾄﾞ</a>|</li>
					<li><a href="./guide.php">推奨環境</a>|</li>
					<li><a href="./?logout=1" onclick="return confirm('ログアウトしますか？')">ログアウト</a></li>
<?}?>
				</ul>
			</div>
			<address><?=SET_COPYRIGHT?></address>
		</div>
