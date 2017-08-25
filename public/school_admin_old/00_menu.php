			<div id="left_menu">
				<a class="ah4<?if(basename($_SERVER['PHP_SELF'])=="main.php"){echo " active";}?> ico_dashboard" href="./main.php">ダッシュボード</a>
				<h4 class="ico_account<?if(stristr(basename($_SERVER['PHP_SELF']), "admin_")){echo " active";}?>">学校情報管理</h4>
				<ul id="menu1">
					<li<?if(basename($_SERVER['PHP_SELF'])=="admin_school.php"){echo " class=\"active\"";}?>><a href="./admin_school.php">・学校基本情報</a></li>
					<li<?if(basename($_SERVER['PHP_SELF'])=="admin_campus.php"){echo " class=\"active\"";}?>><a href="./admin_campus.php">・キャンパス情報</a></li>
				</ul>
				<h4 class="ico_exam_paper<?if(stristr(basename($_SERVER['PHP_SELF']), "exam_")){echo " active";}?>">データ管理</h4>
				<ul id="menu2">
					<li<?if(basename($_SERVER['PHP_SELF'])=="data_document_request.php"){echo " class=\"active\"";}?>><a href="./data_document_request.php">・資料請求</a></li>
				</ul>
				<?if(0){?>
				<h4 class="ico_banner<?if(stristr(basename($_SERVER['PHP_SELF']), "contents_")){echo " active";}?>">コンテンツ管理</h4>
				<ul id="menu3">
					<li<?if(basename($_SERVER['PHP_SELF'])=="contents_massage.php"){echo " class=\"active\"";}?>><a href="./contents_massage.php">・メッセージ</a></li>
				</ul>
				<?}?>
			</div>
