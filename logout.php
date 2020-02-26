<?php
session_start();

require_once './includes/user.class.php';

if (isset($_SESSION['logged_in'])) {
	$User = new App\User();
	$User->logout();
}
header('LOCATION: ' . $_SERVER['HTTP_REFERER']);
exit;
?>