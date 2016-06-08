<?php

	// environment
	// developer mode 
	ini_set('display_errors','on');
	error_reporting(E_ALL);

	include 'config.php';
	require 'sys/helper.php';
	
	// Session 
	Session::init();
	$id=Session::get('id');

	// reading configuration

	$conf=Registry::getInstance();
	
	

	Core::init();

	
