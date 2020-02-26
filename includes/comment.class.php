<?php

namespace App;

require_once 'includes/db.class.php';

class Comment
{
	private $id;
	public $error_message;

	public function __construct($id = null) {
		$this->id = $id;
	}

	public function addComment(array $parms)
	{
		if (!EMPTY($parms['username'] && $parms['email'] && $parms['message'] && $parms['product_id'])) {
			$query = sprintf(
				"INSERT INTO comments 
					(`product_id`, `from_name`, `from_email`, `text`)
				VALUES
					('%d', '%s', '%s', '%s')",
				$parms['product_id'],
				$parms['username'],
				$parms['email'],
				$parms['message']
			);

			Database::query($query);
		}
	}

	public function setStatus(bool $status = null) {
		if ($this->id !== null && $status !== null) {
			$query = sprintf(
				"UPDATE comments
					SET status = %d
				WHERE id = %d",
				$status,
				$this->id
			);

			Database::query($query);
		}
	}
}