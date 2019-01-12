<?php
class Database {
  private $serverIP = "localhost";         // SQL server IP
	private $userName = "redacted";      // SQL user username
	private $password = "redacted";      // SQL user password
	private $database = "redacted";  // SQL database name

	public function connect() {
    //(none)->mysqli
    //returns mysqli object that is connected to database

		$con = new mysqli($this->serverIP, $this->userName, $this->password, $this->database);
		if ($con->connect_error) {
			die($con->connect_error);
		}

		return $con;
	}
}
?>
