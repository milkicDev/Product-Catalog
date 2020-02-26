<?php
session_start();
require_once './includes/product.class.php';
require_once './includes/comment.class.php';

$productClass = new App\Product();

if (isset($_POST['status'])) {
	$commentClass = new App\Comment($_POST['id']);
	$commentClass->setStatus($_POST['status']);

	if (empty($comment->error_message)) {
		header("LOCATION: comments.php");
	}
}

if (!isset($_SESSION['logged_in'])) {
	header('LOCATION: login.php');
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

	<title>Comments - Product Catalog</title>
</head>

<body>
	<?php
	include_once './includes/navbar.php';
	?>

	<div class="container my-5">
		<table class="table table-striped">
			<tbody>
				<?php
				$products = $productClass->getData();

				if (!empty($products)) {
					$first = true;
					foreach ($products as $product) {
						echo '
							<tr>
								<th scope="row" colspan="5" class="bg-dark text-light">' . $product->title . ' - ' . count((array) $product->comments) . ' Comments</th>
							</tr>';

						if ($first) {
							echo '
								<tr>
									<th scope="row">#</th>
									<td>From - Name</td>
									<td>From - E-mail</td>
									<td>Message</td>
									<td>Change Status</td>
								</tr>';
						}

						foreach ($product->comments as $comment) {
							echo '
								<tr>
									<th scope="row">' . $comment->id . '</th>
									<td>' . $comment->from_name . '</td>
									<td>' . $comment->from_email . '</td>
									<td>' . $comment->text . '</td>
									<td>
										<form action="#" method="POST" name="changeStatus">
											<input type="hidden" name="id" value="' . $comment->id . '">
											<select name="status" onchange="this.form.submit()">
												<option value="">Select Status</option>
												<option value="0">Unpublish</option>
												<option value="1">Publish</option>
											</select>
										</form>
									</td>
								</tr>';
						}

						$first = false;
						if (next($product)) {
							$first = true;
						}
					}
				}
				?>
			</tbody>
		</table>
	</div>

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>