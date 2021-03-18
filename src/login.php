<?php

include 'functions.php';

function login($tel, $pass) {

	include 'connection.php';

	if (mysqli_connect_errno()) {
		res_err('Connect failed: '.mysqli_connect_error());
		exit();
	}

	$sql = "SELECT * FROM `users` WHERE `telephone` = '".$tel."'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {

			if(hash_function($pass . $row['salt']) === $row['password']) {

				session_start();

				$_SESSION['me'] = $row;

				res_success('Successfully logged in as ' . $row['username'] . '!');

				return 1;

			}
		}
	} else {
		res_err(lang() == 'en' ? 'User with given phone number was not found' : 'Nie znaleziono użytkownika z podanym numerem telefonu', 'login');
	}

	$conn->close();

	return 0;

}

if(isset($_POST['telephone']) and isset($_POST['password'])) {

	if(!preg_match('/(\+\d{10,12}|\d{9})/', $_POST['telephone'])) {
		res_err(lang() == 'en' ? 'Telephone number invalid' : 'Nieprawidłowy numer telefonu', 'login');
	}

	login($_POST['telephone'], $_POST['password']) or res_err(lang() == 'en' ? 'Phone number or password invalid' : 'Number telefonu lub hasło nieprawidłowe', 'login');

} else {
	res_err(lang() == 'en' ? 'One or more field empty' : 'Niektóre pola są puste', 'login');
}

?>