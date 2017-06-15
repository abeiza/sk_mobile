<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Meta tags-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>suarakaryanews.com | Mobile Web</title>
    <!-- CSS-->
    <link rel="stylesheet" href="<?php echo $url_mobile;?>/assets/css/framework7.ios.min.css">
    <link rel="stylesheet" href="<?php echo $url_mobile;?>/assets/css/framework7.ios.colors.min.css">
    <link rel="stylesheet" href="<?php echo $url_mobile;?>/assets/css/ionicons.css">
    <link rel="stylesheet" href="<?php echo $url_mobile;?>/assets/css/fontello.css">
    <link rel="stylesheet" href="<?php echo $url_mobile;?>/assets/css/style.css">
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo $url_pc;?>assets/img/fav/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo $url_pc;?>assets/img/fav/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo $url_pc;?>assets/img/fav/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo $url_pc;?>assets/img/fav/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo $url_pc;?>assets/img/fav/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo $url_pc;?>assets/img/fav/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo $url_pc;?>assets/img/fav/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo $url_pc;?>assets/img/fav/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $url_pc;?>assets/img/fav/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo $url_pc;?>assets/img/fav/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo $url_pc;?>assets/img/fav/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo $url_pc;?>assets/img/fav/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $url_pc;?>assets/img/fav/favicon-16x16.png">
	<link rel="manifest" href="<?php echo $url_pc;?>assets/img/fav/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="<?php echo $url_pc;?>assets/img/fav/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<script src="<?php echo $url_pc;?>assets/js/front/jquery.min.js"></script>
	
  </head>
  <body>
    <div class="statusbar-overlay"></div>
    <div class="panel-overlay"></div>
	<script>
		function formatMonth(m){
			var monthNames = [
				"Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Des"
			];
			
			return monthNames[m];
		}
	</script>