<!-- 
Project Details
===============
Project Creator: Saneem Perinkadakkat
Twitter: @xaneem
Facebook: http://www.facebook.com/xaneem
GitHub: https://github.com/xaneem/Treasure-Hunt/

This project was originally created for Clueless 2013, an online treasure
hunt conducted as a part of Tathva 2013, the annual techno-management festival of
NIT Calicut.

You're free to use this code for any project, but you should follow the license given below.

If you need any help with the code, or details about how to install it, feel free
to ping me on Facebook or Twitter. Cheers!

LICENSE:
This project is licensed under GNU GENERAL PUBLIC LICENSE Version 2.
You're free to use this project for any purpose, but you
SHOULD provide the source code of any derivation freely available,
along with the proper attribution to the original project creator.

 -->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Clueless is an exciting online treasure hunt, as a part of Tathva, the annual techno-management festival of NIT Calicut.">

	<title><?=$title?></title>
	<link href="<?=base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?=base_url();?>assets/css/style.css" rel="stylesheet">

	<link rel="icon" href="<?=base_url();?>assets/img/favicon.png" type="image/png">
	<link rel="shortcut icon" href="<?=base_url();?>assets/img/favicon.png" type="image/png">


	<meta property="og:title" content="Online Treasure Hunt">
	<meta property="og:type" content="website">
	<meta property="og:url" content="http://www.example.com/">
	<meta property="og:description" content="An exciting online treasure hunt!">
	
	<script src="<?=base_url();?>assets/js/jquery-1.10.2.min.js"></script>
	<!--[if lt IE 9]>
	<script src="/assets/js/html5shiv.js"></script>
	<script src="/assets/js/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<?php
	//code to highlight the current page, in the navbar.

	$active = array(
		'arena' => '',
		'rules' => '',
		'leaderboard' => '',
		'winners' => ''
	);

	switch (uri_string()) {
		case '':
			if($this->session->userdata('is_logged_in')==TRUE)
				$active['arena'] = 'class="active"';
		break;

		case 'rules':
			$active['rules'] = 'class="active"';
		break;

		case 'leaderboard':
			$active['leaderboard'] = 'class="active"';
		break;

		case 'winners':
			$active['winners'] = 'class="active"';
		break;
		
	}


	?>
	<div class="navbar navbar-default navbar-fixed-top navbar-texture">
	  <div class="container">
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" id="clueless-logo" href="<?=base_url();?>"></a>
	    </div>
	    <div class="navbar-collapse collapse">
	      <ul class="nav navbar-nav">
	      	<?php if($this->session->userdata('is_logged_in')==TRUE) { ?>
	        <li <?=$active['arena']?>><a href="<?=base_url();?>">Arena</a></li>
	        <?php } ?>
	        <li <?=$active['rules']?>><a href="<?=base_url();?>rules">Rules</a></li>
	        <li <?=$active['leaderboard']?>><a href="<?=base_url();?>leaderboard">Leaderboard</a></li>
	        <li <?=$active['winners']?>><a href="<?=base_url();?>winners">Winners</a></li>


	        <?php if($this->session->userdata('role')>=2) { ?>
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin Panel <b class="caret"></b></a>
	          <ul class="dropdown-menu">
	            <li><a href="<?=base_url();?>nimda">Home</a></li>
	            <li><a href="<?=base_url();?>nimda/levels">Levels</a></li>
	            <li><a href="<?=base_url();?>nimda/users">Users</a></li>
	          </ul>
	        </li>
	        <?php } ?>


	      </ul>
	      <ul class="nav navbar-nav navbar-right">
	      	<?php if($this->session->userdata('is_logged_in')!=TRUE) { ?>
	        <li><a href="<?=base_url();?>login">Login</a></li>
	        <?php }else { ?>
	        <li><a href="http://www.facebook.com/clueless.tathva" target="_blank">Clues</a></li>
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=$this->session->userdata('fb_name')?> <b class="caret"></b></a>
	          <ul class="dropdown-menu">
	            <li><a href="<?=base_url();?>profile">Profile</a></li>
	            <li class="divider"></li>
	            <li class="dropdown-header"><?=$this->session->userdata('fb_name')?></li>
	            <li><a href="<?=base_url();?>logout">Log-out</a></li>
	          </ul>
	        </li>
	        <?php } ?>
	      </ul>
	    </div><!--/.nav-collapse -->
	  </div>
	</div>