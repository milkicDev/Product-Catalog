<?php
session_start();

require_once './includes/product.class.php';
require_once './includes/comment.class.php';

$productClass = new App\Product();

if (isset($_POST['addComment'])) {
	$comment = new App\Comment();
	$comment->addComment($_POST);
	
	if (EMPTY($comment->error_message)) {
		header("LOCATION: index.php");
	}
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

	<title>Product Catalog</title>
</head>

<body>
	<?php
	include_once './includes/navbar.php';
	?>

	<div class="container my-4">
		<h1 class="text-center mb-4">Hello World</h1>

		<?php
		$products = $productClass->getData(9, 3);
		if (!empty($products)) {
			echo '<div class="row">';
			foreach ($products as $product) {
				echo '
				<div class="col-lg-4">
					<div class="card">';

				if (!empty($product->image)) {
					echo '<img src="' . $product->image . '" alt="Product Image" class="card-img-top w-100" height="200">';
				} else {
					echo '<img src="https://tnthomeimprovements.com/wp-content/uploads/2019/08/placeholder.png" alt="Product Image" class="card-img-top w-100" height="200">';
				}

				echo '
						<div class="card-body">
							Title: ' . $product->title . '<br>
							Description: ' . substr($product->title, 0, 200) . '<br>
							
							<div class="mt-3">
								<div class="float-left">
									<span>Comments <sup class="text-primary">' . count((array) $product->comments) . '</sup></span>
								</div>
								<div class="float-right">
									<small>' . date('H:i d.m.Y', strtotime($product->created_at)) . '</small>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>

						<div class="card-footer">';

				foreach ($product->comments as $comment) {
					if ((bool) $comment->status) {
						echo '
							<div class="comment d-flex my-1 align-items-center">
								<img src="https://tnthomeimprovements.com/wp-content/uploads/2019/08/placeholder.png" alt="No-Avatar Image" width="55" height="55" class="border mr-2">

								<div>
									' . $comment->from_name . '<br>
									' . substr($comment->text, 0, 100) . '
								</div>
							</div>
						';

						if (next($product->comments)) {
							echo '<hr>';
						}
					}
				}

				echo '
							<button class="btn btn-primary btn-sm mt-2" data-toggle="modal" data-target="#addComment" product-id="' . $product->id . '">Add Comment</button>
						</div>
					</div>
				</div>';
			}
			echo '</div>';
		}
		?>
	</div>

	<div class="modal fade" id="addComment" tabindex="-1" role="dialog" aria-labelledby="addCommentLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addCommentLabel">Modal title</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="#" method="POST">
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" class="form-control" name="username" id="username" placeholder="John">
						</div>

						<div class="form-group">
							<label for="email">Email Address</label>
							<input type="email" class="form-control" name="email" id="email" placeholder="name@example.com">
						</div>

						<div class="form-group">
							<label for="message">Example textarea</label>
							<textarea class="form-control" id="message" name="message" rows="3"></textarea>
						</div>

						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary" name="addComment">Add Comment</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<script>
		$('[data-target="#addComment"]').click(function() {
			var hiddenInputID = '<input type="hidden" name="product_id" value="' + $(this).attr('product-id') + '">';
			$('.modal-body > form').append(hiddenInputID);
		});
	</script>
</body>

</html>