<?php
class Api {
  public function create() {
    //(none)->none
    //creates new api key

    require_once("Database.php");
    require_once("Util.php");

    $database = new Database();
    $con = $database->connect();

    $util = new Util();

    $key = md5(date("Y-m-d H:i:s"));
    $output = $_GET['output'];

    $sql = "INSERT INTO users (apikey) VALUES ('$key')";

    if(strtolower($output) == "json") {
      if ($con->query($sql) === TRUE) {
        $apikey["apikey"] = $key;
        $util->toJSON($apikey);
      } else {
        echo "<h1> 400 Database Error </h1>";
        echo "<h3> There was an error connecting to the database </h3>";
        http_response_code(500);
      }
    } else {
      echo "<h1> 400 Bad Request </h1>";
      echo "<h3> Incorrect Output Format </h3>";
      http_response_code(400);
    }
  }

  public function revoke($key) {
    //(string)->none
    //revokes api key

    require_once("Database.php");
    require_once("Util.php");

    $database = new Database();
    $con = $database->connect();

    $util = new Util();

    $key = $con->escape_string($key);
    $output = $_GET['output'];

    $sql = "UPDATE users SET status=1 WHERE apikey='$key'";

    if(strtolower($output) == "json") {
      if ($con->query($sql) === TRUE) {
        $data["status"] = "revoked";
        $util->toJSON($data);
      } else {
        echo "<h1> 400 Database Error </h1>";
        echo "<h3> There was an error connecting to the database </h3>";
        die(http_response_code(500));
      }
    } else {
      echo "<h1> 400 Bad Request </h1>";
      echo "<h3> Incorrect output format </h3>";
      die(http_response_code(400));
    }
  }

  public function validate() {
    //(none)->boolean
    //verifies api key

    require_once("Database.php");

    $database = new Database();
    $con = $database->connect();

    $key = $con->escape_string($_GET["apikey"]);

    $sql = "SELECT * FROM `users` WHERE apikey = '$key' AND status = 0";
    $result = $con->query($sql);
    if($result->num_rows == 0) {
      echo "<h1> 403 Forbidden </h1>";
      echo "<h3> Incorrect api key </h3>";
      die(http_response_code(403));
    }
  }
}

?>
