<?php

$dbhost = getenv('DB_HOST');
$dbuser = getenv('DB_USER');
$dbpass = getenv('DB_PASS');
$dbname = getenv('DB_NAME');

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Unable to connect to a database');

?>