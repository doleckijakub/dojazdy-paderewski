<?php

function hash_function($e) {
	return md5($e);
}

function lang() {
	$l = 'pl';
	if(isset($_COOKIE['lang'])) $l = $_COOKIE['lang'];
	return $l;
}

function goto_index() {
	header('Location: /pp/'.lang());
}

function res_err($err, $last_act) {

	echo $err;

	if($err) {
		$h = 'Location: /pp/'.lang().'/?last_act='.$last_act.'&err='.$err;
		if(isset($_POST['username'])) { $h .= '&username='.$_POST['username']; }
		if(isset($_POST['telephone'])) { $h .= '&tel='.$_POST['telephone']; }
		header($h);
	} else {
		header('Location: /pp/'.lang().'/?last_act='.$last_act);
	}

	exit();
}

function res_success($success) {

	echo $success;

	if($success) {
		$h = 'Location: /pp/'.lang().'/?success='.$success;
		header($h);
	} else {
		header('Location: /pp/'.lang().'/');
	}

	exit();
}