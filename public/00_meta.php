	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<?if($TOP_FLAG==1){?>
	<title><?=SET_SITE_TITLE?></title>
	<meta name="description" content="<?=SET_META_DESCRIPTION?>">
	<meta name="keywords" content="<?=SET_META_KEYWORDS?>">
	<meta name="author" content="<?=SET_SITE_MASTER?>">
	<link rel="canonical" href="<?=SET_SITE_URL?>">
	<meta property="og:title" content="<?=SET_SITE_TITLE?>" />
	<meta property="og:type" content="website" />
	<meta property="og:site_name" content="<?=SET_SITE_TITLE?>" />
	<meta property="og:description" content="<?=SET_META_DESCRIPTION?>"/>
	<meta property="og:url" content="<?=SET_SITE_URL?>" />
	<meta property="og:image" content="<?=SET_SITE_URL?>/og.jpg" />
	<meta property="og:image:width" content="1200">
	<meta property="og:image:height" content="630">
	<meta property="fb:admins" content="----------------------" />
	<meta name="thumbnail" content="<?=SET_SITE_URL?>" />
<?}else{?>
	<title><?=$PAGE_TITLE?>|<?=SET_SITE_TITLE?></title>
	<meta name="description" content="<?=$PAGE_DESCRIPTION?>">
	<meta name="keywords" content="<?=$PAGE_KEYWORDS?>">
	<meta name="author" content="<?=SET_SITE_MASTER?>">
	<link rel="<?=SET_SITE_URL?>">
<?}?>
	<link rel="icon" type="image/png" href="<?=SET_ROOT_DIR?>/img/icon/favicon.ico">
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	<link rel="shortcut icon" href="<?=SET_ROOT_DIR?>/img/icon/favicon.ico" type="image/x-icon" />
	<link rel="icon" href="<?=SET_ROOT_DIR?>/img/icon/favicon.ico" type="image/x-icon" />
	<link rel="apple-touch-icon-precomposed" href="<?=SET_ROOT_DIR?>/img/icon/apple-touch-icon-precomposed.png" />
	<meta name="msapplication-TileImage" content="<?=SET_ROOT_DIR?>/img/icon/fav_144_144.png" />
	<!-- stylesheets -->
<?if($TOP_FLAG==1){?>
	<link rel="stylesheet" type="text/css" media="all" href="<?=SET_ROOT_DIR?>/css/import_top.css" />
<?}else{?>
	<link rel="stylesheet" type="text/css" media="all" href="<?=SET_ROOT_DIR?>/css/import_middle.css" />
<?}?>
	<!--[if lt IE 9]>
	<script type="text/javascript" src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript" src="<?=SET_ROOT_DIR?>/js/main.js"></script>
<?if($TOP_FLAG==1){?>
	<link rel="stylesheet" type="text/css" href="<?=SET_ROOT_DIR?>/css/jquery.bxslider.css" media="screen" />
	<script type="text/javascript" src="<?=SET_ROOT_DIR?>/js/jquery.bxslider.min.js"></script>
<?}?>
