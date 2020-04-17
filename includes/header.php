<?php

require 'config/config.php';

?>

<html>

<head>
	<title>Office reservation</title>

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

	<!-- Javascript -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/bootbox.min.js"></script>
	
	
</head>

<body>

	<div class="top_bar">

		<div class="logo">
			<a href="index.php">Office reservation!</a>
		</div>

		<nav>
			
			<a href="management_view.php">
				Workplace management
			</a>
			<a href="reservation_view.php">
				Workplace reservation
			</a>
			
		</nav>

	</div>

	<!-- this div will be closed in index file -->
	<div class="wrapper">