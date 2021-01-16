<?php

// $uri .= $_SERVER['HTTP_HOST'];

$lang = 'pl';
if(isset($_COOKIE['lang'])) $lang = $_COOKIE['lang'];

header('Location: /pp/'.$lang.'/');
// header("Content-Type: image/jpg"); echo file_get_contents('https://eu.ui-avatars.com/api/?&name=Mariusz%20Pudzianowski&size=64&rounded=true&background=0D8ABC&color=fff&bold=true');