					<div class="admin_tab_menu">
						<a href="./admin_school.php?edit=<?=$edit_school_id?>" class="btn btn-glay<?if(basename($_SERVER['PHP_SELF'])=="admin_school.php"){echo "_act";}?>">基本情報</a>
						<a href="./admin_curriculum.php?edit=<?=$edit_school_id?>" class="btn btn-glay<?if(basename($_SERVER['PHP_SELF'])=="admin_curriculum.php"){echo "_act";}?>">カリキュラム･コース</a>
						<a href="./admin_requirements.php?edit=<?=$edit_school_id?>" class="btn btn-glay<?if(basename($_SERVER['PHP_SELF'])=="admin_requirements.php"){echo "_act";}?>">募集要項･学費</a>
						<a href="./admin_school_life.php?edit=<?=$edit_school_id?>" class="btn btn-glay<?if(basename($_SERVER['PHP_SELF'])=="admin_school_life.php"){echo "_act";}?>">スクールライフ</a>
						<!--<a href="./admin_voice.php?edit=<?=$edit_school_id?>" class="btn btn-glay<?if(basename($_SERVER['PHP_SELF'])=="admin_voice.php"){echo "_act";}?>">各種声</a>-->
					</div>
