<?php

include 'connection.php';
include 'functions.php';

session_start();

if(
	isset($_POST['route__start'])
) {

	if(isset($_SESSION['me'])) {
		if(isset($_SESSION['me']['id'])) {
			if (mysqli_connect_errno()) {
				res_err('Connect failed: '.mysqli_connect_error());
				exit();
			}

			// $sql = "UPDATE `users` SET `route__start` = '".$_POST['route__start']."', `route_point_1` = '".$_POST['route_point_1']."', `route_point_2` = '".$_POST['route_point_2']."', `route_point_3` = '".$_POST['route_point_3']."' WHERE `users`.`id` = ".$_SESSION['me']['id'];
			// $conn->query($sql) or res_err(lang() == 'en' ? 'An error occured while executing database querry' : 'Wystąpił błąd podczas integracji z bazą danych', 'index');

			foreach(array('route__start','route_point_1','route_point_2','route_point_3') as $i => $key) {
				if(isset($_POST[$key])) {
					$sql = "UPDATE `users` SET `".$key."` = '".$_POST[$key]."' WHERE `users`.`id` = ".$_SESSION['me']['id'];
					$conn->query($sql) or res_err(lang() == 'en' ? 'An error occured while executing database querry' : 'Wystąpił błąd podczas integracji z bazą danych', 'index');

					$_SESSION['me'][$key] = $_POST[$key];
				}
			}

			res_success('Successfully edited the route!');
		} else {
			res_err(lang() == 'en' ? 'not logged in' : 'nie jesteś zalogowany', 'index');
		}
	} else {
		res_err(lang() == 'en' ? 'not logged in' : 'nie jesteś zalogowany', 'index');
	}

} else {
	res_err(lang() == 'en' ? 'one or more field empty' : 'niektóre pola są puste', 'index');
}

?>