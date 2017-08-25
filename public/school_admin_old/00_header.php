		<div id="header">
			<h1><?=SET_SITE_TITLE_S?><span class="f14">[学校管理画面]</span></h1>
<?
	//ログインページ/フォゲットページでは以下非表示
	if(basename($_SERVER['PHP_SELF'])!="index.php" && basename($_SERVER['PHP_SELF'])!="forget.php"){
?>
			<div id="head_info_box">
				<div class="ac_name"><?echo greet();?>　[<?=$school_name?>]さま</div>
				<a class="fcbox3" href="./help.php?help_id=<?=basename($_SERVER['PHP_SELF'],".php")?>" title="このページの使い方">HELP</a>
				<a href="./?logout=1" onclick="return confirm('ログアウトしますか？')">Logout</a>
			</div>
<?
	}
?>
		</div>
