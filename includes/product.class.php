<?php

namespace App;

require_once 'includes/db.class.php';

class Product
{
	private $id;

	public function __construct($id = null)
	{
		$this->id = $id;
	}

	public function getData($limit = null, $commentLimit = null)
	{
		$query = '';
		if ($this->id !== null) {
			$query = sprintf("SELECT * FROM `products` WHERE id = %d", $this->id);
		} else {
			$query = sprintf("SELECT * FROM products ORDER BY created_at DESC");

			if ($limit !== null) {
				$query .= sprintf(" LIMIT %d", $limit);
			}
		}
		$result = Database::query($query);


		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = (object) $row;
			foreach ($data as $key => $val) {
				$data[$key]->comments = Database::Select('comments', null, ['product_id' => $data[$key]->id], '=', ['by' => 'created_at', 'sort' => 'desc'], $commentLimit);
			}
		}

		return (object) $data;
	}
}