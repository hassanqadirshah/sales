<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="content-language" content="en" />
	<meta name="robots" content="noindex,nofollow" />
	<link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo base_url() ?>css/reset.css" /> <!-- RESET -->
	<link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo base_url() ?>css/main.css" /> <!-- MAIN STYLE SHEET -->
	<link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo base_url() ?>css/2col.css" title="2col" /> <!-- DEFAULT: 2 COLUMNS -->
	<link rel="alternate stylesheet" media="screen,projection" type="text/css" href="<?php echo base_url() ?>css/1col.css" title="1col" /> <!-- ALTERNATE: 1 COLUMN -->
	<!--[if lte IE 6]><link rel="stylesheet" media="screen,projection" type="text/css" href="css/main-ie6.css" /><![endif]--> <!-- MSIE6 -->
	<link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo base_url() ?>css/admin_style.css" /> <!-- GRAPHIC THEME -->
	<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>js/switcher.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>js/toggle.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>js/ui.core.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>js/ui.tabs.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$(".tabs > ul").tabs();
	});
	</script>
	<title>Admin Panel</title>
</head>

<body>

<div id="main">

	<!-- Tray -->
	<div id="tray" class="box">

            <p class="f-right">User: <strong><a href="#"><?php foreach ($user_record as $row){ echo $row->position; }?></a></strong></p>

	</div> <!--  /tray -->

	<hr class="noscreen" />

	<!-- Menu -->
	<div id="menu" class="box">

		<ul class="box f-right">
			<li><a href="<?php echo site_url() ?>/sales"><span><strong>Visit Site &raquo;</strong></span></a></li>
		</ul>

		<ul class="box">
			<li id="menu-active"><a href="<?php echo site_url() ?>/admin"><span>Profile</span></a></li> <!-- Active -->
			<li><a href="<?php echo site_url() ?>/admin/edit_profile"><span>Edit</span></a></li>
                        <?php foreach ($user_record as $row){ if($row->position == 'Administrator'){ ?>
			<li><a href="<?php echo site_url() ?>/admin/emplyee_profile"><span>Emplyees</span></a></li>
                        <li><a href="<?php echo site_url() ?>/admin/pending_request"><span>Pending Request</span></a></li>
                        <?php } } ?>
		</ul>

	</div> <!-- /header -->

	<hr class="noscreen" />