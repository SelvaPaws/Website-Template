<?php
class DatabaseAccess {
	
	private $host;
	private $user;
	private $password;
	private $database;
	private $connection;
	
	public function __construct($database = '') {
		require('settings/mysql.php');
		$this->host = $_MYSQL['host'];
		$this->username = $_MYSQL['user'];
		$this->password = $_MYSQL['password'];
		$this->connect();
		if ($database != '')
			$this->select_db($database);
	}
	
	protected function connect() {
		///$this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
		$this->connection = mysql_connect($this->host, $this->username, $this->password);
	}
	
	protected function checkError() { //shows an error screen if the query failed.
		if (mysql_error()) {
			raiseError(500);
			die();
		}
	}
	
	public function selectDb($db) {
		$this->database = $db;
		mysql_select_db($this->database);
	}
	
	public function count($query) {
		$result = mysql_query($query);
		$this->checkError();
		return mysql_num_rows($result);
	}
	
	public function fetchSingle($query) {
		$result = mysql_query($query);
		$this->checkError();
		return mysql_fetch_assoc($result);
	}
	
	public function fetchSingleField($query, $field) {
		$result = mysql_query($query);
		$this->checkError();
		$record = mysql_fetch_assoc($result);
		return $record[$field];
	}

	public function fetchAll($query) {
		$result = mysql_query($query);
		$this->checkError();
		$records = array();
		while ($row = mysql_fetch_assoc($result))
			$records[sizeof($records)] = $row;
		return $records;
	}

	public function query($query) {
		$result = mysql_query($query);
		$this->checkError();
		return $result;
	}
	
	public function close() {
		mysql_close($this->connection);
	}
}
?>