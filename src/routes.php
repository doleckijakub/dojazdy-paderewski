<?php

	header('Content-type: application/json');

	include 'connection.php';
	include 'functions.php';

	$routes = array();

	$sql = "SELECT `username`,`telephone`,`route__start`,`route_point_1`,`route_point_2`,`route_point_3` FROM `users` WHERE NOT `route__start` IS NULL";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			array_push($routes, array(
				'start' => $row['route__start'],
				'point_2' => $row['route_point_1'],
				'point_3' => $row['route_point_2'],
				'point_4' => $row['route_point_3'],
				'username' => $row['username'],
				'telephone' => $row['telephone']
			));
		}
	} else {
		res_err(lang() == 'en' ? 'Could not establish database connection' : 'Nie udało się połączyć z bazą danych', 'index');
	}

	$routes = json_encode($routes, JSON_UNESCAPED_UNICODE);

	echo $routes;

?>