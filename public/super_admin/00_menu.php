			<div id="left_menu">
				<a class="ah4<?if(basename($_SERVER['PHP_SELF'])=="main.php"){echo " active";}?> ico_dashboard" href="./main.php">ダッシュボード</a>
				<h4 class="ico_school<?if(stristr(basename($_SERVER['PHP_SELF']), "admin_")){echo " active";}?>">学校情報管理</h4>
				<ul id="menu1">
					<li<?if(basename($_SERVER['PHP_SELF'])=="admin_school.php"){echo " class=\"active\"";}?>><a href="./admin_school.php">・学校基本情報</a></li>
					<li<?if(basename($_SERVER['PHP_SELF'])=="admin_curriculum.php"){echo " class=\"active\"";}?>><a href="./admin_curriculum.php">・カリキュラム/コース</a></li>
					<li<?if(basename($_SERVER['PHP_SELF'])=="admin_requirements.php"){echo " class=\"active\"";}?>><a href="./admin_requirements.php">・募集要項/学費</a></li>
					<li<?if(basename($_SERVER['PHP_SELF'])=="admin_school_life.php"){echo " class=\"active\"";}?>><a href="./admin_school_life.php">・スクールライフ</a></li>
					<!--<li<?if(basename($_SERVER['PHP_SELF'])=="admin_voice.php"){echo " class=\"active\"";}?>><a href="./admin_voice.php">・各種声</a></li>-->
					<li<?if(basename($_SERVER['PHP_SELF'])=="admin_event.php"){echo " class=\"active\"";}?>><a href="./admin_event.php">・イベント情報</a></li>
				</ul>
				<h4 class="ico_exam_paper<?if(stristr(basename($_SERVER['PHP_SELF']), "exam_")){echo " active";}?>">データ管理</h4>
				<ul id="menu2">
					<li<?if(basename($_SERVER['PHP_SELF'])=="data_document_request.php"){echo " class=\"active\"";}?>><a href="./data_document_request.php">・資料請求</a></li>
				</ul>
				<h4 class="ico_banner<?if(stristr(basename($_SERVER['PHP_SELF']), "contents_")){echo " active";}?>">コンテンツ管理</h4>
				<ul id="menu3">
					<li<?if(basename($_SERVER['PHP_SELF'])=="contents_news.php"){echo " class=\"active\"";}?>><a href="./contents_news.php">・お知らせ</a></li>
					<li<?if(basename($_SERVER['PHP_SELF'])=="contents_feature_school.php"){echo " class=\"active\"";}?>><a href="./contents_feature_school.php">・フィーチャー校指定</a></li>
					<li<?if(basename($_SERVER['PHP_SELF'])=="contents_concierge.php"){echo " class=\"active\"";}?>><a href="./contents_concierge.php">・進学コンシェルジュ</a></li>
				</ul>
				<?if($admin_id=="arai"||$admin_id=="kishi"){?>
				<h4 class="ico_config<?if(stristr(basename($_SERVER['PHP_SELF']), "config_")){echo " active";}?>">設定管理</h4>
				<ul id="menu3">
					<li><a href="https://mysql.kagoya.com/o4012-259/" target="_blank">・PhpMyadmin</a></li>
				</ul>
				<?}?>
			</div>
