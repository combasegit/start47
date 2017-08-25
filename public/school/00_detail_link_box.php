			<div id="detail_link_box">
				<ul>
					<li<?if($sc_top_flag==1){echo " class=\"active\"";}?>><a href="/school/<?=$school_id?>/">基本情報</a></li>
					<?if($c_cnt>0){?><li<?if(basename($_SERVER['PHP_SELF'])=="curriculum.php"){echo " class=\"active\"";}?>><a href="/school/<?=$school_id?>/curriculum.html">カリキュラム/コース</a></li><?}?>
					<?if(strlen($schooling_title)||strlen($schooling_txt)){?><li<?if(basename($_SERVER['PHP_SELF'])=="schooling.php"){echo " class=\"active\"";}?>><a href="/school/<?=$school_id?>/schooling.html">登校スタイル</a></li><?}?>
					<li<?if(basename($_SERVER['PHP_SELF'])=="campus.php"){echo " class=\"active\"";}?>><a href="/school/<?=$school_id?>/campus.html">キャンパス所在地</a></li>
					<?if(strlen($admission_number)||strlen($qualification_admission)||strlen($admission_period)||strlen($selection_process)){?><li<?if(basename($_SERVER['PHP_SELF'])=="requirements.php"){echo " class=\"active\"";}?>><a href="/school/<?=$school_id?>/requirements.html">募集要項</a></li><?}?>
					<?if(strlen($entrance_fee)||strlen($school_fee)||strlen($material_fee)||strlen($facility_fee)||strlen($sundry_expenses)||strlen($total_fee)||strlen($fee_note)){?><li<?if(basename($_SERVER['PHP_SELF'])=="fee.php"){echo " class=\"active\"";}?>><a href="/school/<?=$school_id?>/fee.html">学費</a></li><?}?>
					<?if(strlen($regulation_title)||strlen($regulation_txt)){?><li<?if(basename($_SERVER['PHP_SELF'])=="regulation.php"){echo " class=\"active\"";}?>><a href="/school/<?=$school_id?>/regulation.html">服装・規定</a></li><?}?>
					<?if(strlen($club_title)||strlen($club_txt)){?><li<?if(basename($_SERVER['PHP_SELF'])=="club.php"){echo " class=\"active\"";}?>><a href="/school/<?=$school_id?>/club.html">クラブ活動</a></li><?}?>
					<?if(strlen($event_title)||strlen($event_txt)){?><li<?if(basename($_SERVER['PHP_SELF'])=="event.php"){echo " class=\"active\"";}?>><a href="/school/<?=$school_id?>/event.html">イベント・行事</a></li><?}?>
					<?if($n_cnt>0){?><li<?if(stristr($_SERVER['PHP_SELF'], "/school/news/")){echo " class=\"active\"";}?>><a href="/school/<?=$school_id?>/news/">お知らせ</a></li><?}?>
					<?if(0){/*現在調整中*/?>
					<li<?if(basename($_SERVER['PHP_SELF'])=="voice_obog.php"){echo " class=\"active\"";}?>><a href="/school/<?=$school_id?>/voice_obog.html">卒業生の声</a></li>
					<li<?if(basename($_SERVER['PHP_SELF'])=="voice_student.php"){echo " class=\"active\"";}?>><a href="/school/<?=$school_id?>/voice_student.html">学生の声</a></li>
					<li<?if(basename($_SERVER['PHP_SELF'])=="voice_teacher.php"){echo " class=\"active\"";}?>><a href="/school/<?=$school_id?>/voice_teacher.html">先生の声</a></li>
					<?}?>
				</ul>
			</div>
