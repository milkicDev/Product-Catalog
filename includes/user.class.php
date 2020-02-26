<?php

namespace App;

require_once 'includes/db.class.php';

class User
{
	public $error_message;

	public function login()
	{
		$User = Database::Select('users', null, ['email' => $_POST['email']]);

		if (!empty($User)) {
			if (
				$User->email === $_POST['email']
				&& $User->password === md5($_POST['password'])
				&& (bool) $User->admin
			) {
				$_SESSION['logged_in'] = $User->id;
				header('LOCATION: index.php');
			} else {
				$this->error_message = 'Sorry, but we can\'t give you access to our website!';
			}
		} else {
			$this->error_message = 'Sorry, but you don\'t have account!';
		}
	}

	public function logout()
	{
		session_destroy();
	}
}
