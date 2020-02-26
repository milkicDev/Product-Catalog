<?php
session_start();
require_once './includes/user.class.php';

if (isset($_POST['submitLogin'])) {
	$User = new App\User();
	$User->login();
}

if (isset($_SESSION['logged_in'])) {
	header('LOCATION: index.php');
}
?>

<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<title>Login - Product Catalog</title>
</head>

<body>
	<?php
	include_once './includes/navbar.php';
	?>

	<div class="container my-5">
		<div class="row justify-content-center">
			<div class="col-lg-5 my-5">
				<?php
				if (!empty($User->error_message)) {
					echo '
					<div class="alert alert-danger" role="alert">' . $User->error_message . '</div>';
				}
				?>

				<div class="card">
					<div class="card-body">
						<h4 class="text-center">Login Page</h4>

						<form action="login.php" method="POST">
							<div class="form-group">
								<label for="email">Email address</label>
								<input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
							</div>
							<div class="form-group">
								<label for="password">Password</label>
								<input type="password" name="password" class="form-control" id="password" placeholder="Password">
							</div>
							<button type="submit" name="submitLogin" class="btn btn-primary">Submit</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>