<?php

function hash_function($e) {
	return hash("sha512", $e);
}

function lang() {
	$l = 'pl';
	if(isset($_COOKIE['lang'])) $l = $_COOKIE['lang'];
	return $l;
}

function goto_index() {
	header('Location: /'.lang());
}

function res_err($err, $last_act) {

	echo $err;

	if($err) {
		$h = 'Location: /'.lang().'/?last_act='.$last_act.'&err='.$err;
		if(isset($_POST['first-name'])) { $h .= '&first-name='.$_POST['first-name']; }
		if(isset($_POST['last-name'])) { $h .= '&last-name='.$_POST['last-name']; }
		if(isset($_POST['telephone'])) { $h .= '&tel='.$_POST['telephone']; }
		header($h);
	} else {
		header('Location: /'.lang().'/?last_act='.$last_act);
	}

	exit();
}

function res_success($success) {

	echo $success;

	if($success) {
		$h = 'Location: /'.lang().'/?success='.$success;
		header($h);
	} else {
		header('Location: /'.lang().'/');
	}

	exit();
}