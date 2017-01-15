<?php
	require_once(dirname(__FILE__) . '/../system/FormController.php');
	require_once(dirname(__FILE__) . '/../system/lib.php');
	require_once(dirname(__FILE__) . '/../etc/config.php');
	$ctl = new FormController();
	$ctl->run('finish');
