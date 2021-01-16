<?php

include 'functions.php';

session_start();

unset($_SESSION['me']);

goto_index();

?>