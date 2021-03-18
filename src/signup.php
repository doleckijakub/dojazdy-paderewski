<?php

include 'connection.php';
include 'functions.php';

if(
	isset($_POST['first-name']) and
	isset($_POST['last-name']) and
	isset($_POST['telephone']) and
	isset($_POST['pass-1']) and
	isset($_POST['pass-2']) and
	isset($_POST['id-card-nr'])
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

	if(!preg_match('/^[a-zA-Z ąćęółńżźśĄĆĘÓŁŃŻŹŚ]{3,20}[a-zA-ZąćęółńżźśĄĆĘÓŁŃŻŹŚ]*$/', $_POST['first-name'])) {
		res_err(lang() == 'en' ? 'first name invalid' : 'nieprawidłowe imię', 'signup');
	}

	if(!preg_match('/^[a-zA-Z ąćęółńżźśĄĆĘÓŁŃŻŹŚ]{3,20}[a-zA-ZąćęółńżźśĄĆĘÓŁŃŻŹŚ]*$/', $_POST['last-name'])) {
		res_err(lang() == 'en' ? 'last name invalid' : 'nieprawidłowe nazwisko', 'signup');
	}

	if(!preg_match('/(\+[0-9]{10,12}|[0-9]{9})/', $_POST['telephone'])) {
		res_err(lang() == 'en' ? 'telephone number invalid' : 'nieprawidłowy numer telefonu', 'signup');
	}

	if(!preg_match('/^[0-9]+$/', $_POST['id-card-nr'])) {
		res_err(lang() == 'en' ? 'id card number is not a number' : 'numer legitymacji nie jest numerem', 'signup');
	}

	if (mysqli_connect_errno()) {
		res_err('Connect failed: '.mysqli_connect_error());
		exit();
	}

	$username = $_POST['first-name'].' '.$_POST['last-name'];
	$telephone = $_POST['telephone'];
	$password = $_POST['pass-1'];
	$id_card_nr = $_POST['id-card-nr'];

	$sql = "SELECT * FROM `id_numbers` WHERE `number` = '".$id_card_nr."'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			if($row['is_used'])
				res_err(lang() == 'en' ? 'id card number is already being used' : 'numer legitymacji jest już w użytku', 'signup');
		}
	} else {
		res_err(lang() == 'en' ? 'id card number invalid' : 'nieprawidłowy numer legitymacji', 'signup');
	}

	$salt = hash_function(random_bytes(512));
	$salted_pass = $password . $salt;
	$hashed_salted_pass = hash_function($salted_pass);

	$sql = "SELECT * FROM `users` WHERE `telephone` = '".$telephone."'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) res_err(lang() == 'en' ? 'A user with this phone number already exists' : 'Użytkownik z tym numberem telefonu już istnieje', 'signup');

	$sql = "SELECT * FROM `users` WHERE `username` = '".$username."'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) res_err(lang() == 'en' ? 'A user with this username already exists' : 'Użytkownik z tą nazwą użytkownika już istnieje', 'signup');

	$sql = 'INSERT INTO `users` (`username`, `telephone`, `salt`, `password`, `is_mod`, `route__start`, `route_point_1`, `route_point_2`, `route_point_3`) VALUES (\''.$username.'\', \''.$telephone.'\' , \''.$salt.'\', \''.$hashed_salted_pass.'\', \'0\', NULL, NULL, NULL, NULL)';

	$conn->query($sql) or res_err(lang() == 'en' ? 'An error occured while executing database querry' : 'Wystąpił błąd podczas integracji z bazą danych', 'signup');

	$sql = "UPDATE `id_numbers` SET `is_used` = '1' WHERE `id_numbers`.`number` = '".$id_card_nr."'";
	$conn->query($sql) or res_err(lang() == 'en' ? 'An error occured while executing database querry' : 'Wystąpił błąd podczas integracji z bazą danych', 'signup');

	res_success(lang() == 'en' ? 'Account created successfully' : 'Konto utworzono pomyślnie', 'signup');

} else {
	res_err(lang() == 'en' ? 'one or more field empty' : 'niektóre pola są puste', 'signup');
}

?>