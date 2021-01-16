<?php

include 'connection.php';
include 'functions.php';

if(
	isset($_POST['username']) and
	isset($_POST['telephone']) and
	isset($_POST['pass-1']) and
	isset($_POST['pass-2']) and
	isset($_POST['tutor'])
) {

	if(!isset($_POST['eula'])) {
		res_err(lang() == 'en' ? 'you have to agree to processing of your personal data' : 'muszisz wyrazić zgodę na przetwarzanie danych osobowych', 'signup');
	}

	if(!isset($_POST['is-parent'])) {
		res_err(lang() == 'en' ? 'you have to be a Paderewski\'s student\'s parent' : 'musisz być rodzicem ucznia MLO Paderewski', 'signup');
	}

	if($_POST['pass-1'] !== $_POST['pass-2']) {
		res_err(lang() == 'en' ? 'passwords don\'t match' : 'hasła się nie zgadzają', 'signup');
	}

	if(!preg_match('/^[a-zA-Z ąćęółńżźśĄĆĘÓŁŃŻŹŚ]{5,49}[a-zA-ZąćęółńżźśĄĆĘÓŁŃŻŹŚ]*$/', $_POST['username'])) {
		res_err(lang() == 'en' ? 'username invalid' : 'nieprawidłowa nazwa uzytkownika', 'signup');
	}

	if(!preg_match('/(\+\d{10,12}|\d{9})/', $_POST['telephone'])) {
		res_err(lang() == 'en' ? 'telephone number invalid' : 'nieprawidłowy numer telefonu', 'signup');
	}

	$username = $_POST['username'];
	$telephone = $_POST['telephone'];
	$password = $_POST['pass-1'];
	$salt = hash_function(random_bytes(128));
	$salted_pass = $password . $salt;
	$hashed_salted_pass = hash_function($salted_pass);

	if (mysqli_connect_errno()) {
		res_err('Connect failed: '.mysqli_connect_error());
		exit();
	}

	$sql = "SELECT * FROM `users` WHERE `telephone` = '".$telephone."'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) res_err(lang() == 'en' ? 'A user with this phone number already exists' : 'Użytkownik z tym numberem telefonu już istnieje', 'signup');

	$sql = "SELECT * FROM `users` WHERE `username` = '".$username."'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) res_err(lang() == 'en' ? 'A user with this username already exists' : 'Użytkownik z tą nazwą użytkownika już istnieje', 'signup');

	$sql = 'INSERT INTO `users` (`username`, `telephone`, `salt`, `password`, `is_mod`, `route__start`, `route_point_1`, `route_point_2`, `route_point_3`) VALUES (\''.$username.'\', \''.$telephone.'\' , \''.$salt.'\', \''.$hashed_salted_pass.'\', \'0\', NULL, NULL, NULL, NULL)';

	$conn->query($sql) or res_err(lang() == 'en' ? 'An error occured while executing database connection' : 'Wystąpił błąd podczas połączenia z bazą danych', 'signup');

	res_success(lang() == 'en' ? 'Account created successfully' : 'Konto utworzono pomyślnie', 'signup');

} else {
	res_err(lang() == 'en' ? 'one or more field empty' : 'niektóre pola są puste', 'signup');
}

?>