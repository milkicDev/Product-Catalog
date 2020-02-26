<?php

namespace App;

require_once 'configuration.php';

class Database
{
	private static $conn, $query;

	public static function query($query)
	{
		self::OpenConnection();

		$result = self::$conn->query($query);

		self::CloseConnection();

		return $result;
	}

	public static function Select(
		$table = null, $parms = null, array $where = null,
		$operator = '=', array $order = null, $limit = null
	)
	{
		self::OpenConnection();

		self::$query = '';
		if ($table !== null && $parms === null) {
			self::$query = sprintf("SELECT * FROM `%s`", $table);
		}
		else if ($table !== null && $parms !== null) {
			if (!is_array($parms)) {
				self::$query = sprintf("SELECT `%s` FROM `%s`", $parms, $table);
			} else {
				self::$query = sprintf("SELECT ");
				$select = implode(', ', $parms);
				self::$query .= $select;
				self::$query .= sprintf(" FROM `%s`", $table);
			}
		}

		if (is_array($where) && $where !== null) {
			self::$query .= ' WHERE ';
			foreach ($where as $key => $val) {
				if (trim($val !== '')) {
					$whereIs[] = sprintf("`%s` %s '%s'", $key, $operator, $val);
				}
			}

			$where_statement = implode(" AND ", $whereIs);
			self::$query .= '(' . $where_statement . ')';
		}

		if ($order !== null) {
			self::$query .= sprintf(" ORDER BY `%s` %s ", $order['by'], $order['sort']);
		}

		if ($limit !== null) {
			self::$query .= sprintf(" LIMIT %d", $limit);
		}

		$result = self::$conn->query(self::$query);
		self::CloseConnection();

		$data = array();
		while ($row = $result->fetch_assoc()) {
			if ($result->num_rows > 1) {
				$data[] = (object) $row;
			} else {
				$data = (object) $row;
			}
			
		}

		return (object) $data;
	}

	private static function OpenConnection()
	{
		self::$conn = new \mysqli(db_host, db_user, db_pass, db_name);
		self::$conn->set_charset('utf8');

		if (self::$conn->connect_error) {
			die('ERROR: ' . self::$conn->connect_errno . ' - ' . self::$conn->connect_error);
		}
	}

	private static function CloseConnection()
	{
		self::$conn->close();
	}
}
