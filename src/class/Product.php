<?php
class Product {
  public function exists($title) {
    //(string)->boolean
    //returns if product exists

    require_once("Database.php");
    require_once("Util.php");

    $database = new Database();
    $con = $database->connect();

    $title = $con->escape_string($title);
    $sql = "SELECT `title`, `price`, `inventory_count` FROM `products` WHERE title = '$title' AND inventory_count > 0";

    $result = $con->query($sql);
    if($result->num_rows > 0) {
        return true;
      } else {
        echo "<h1> 400 Bad Request </h1>";
        echo "<h3> Product not found </h3>";
        die(http_response_code(400));
        return false;
      }
  }

  public function getProduct($title) {
    //(string)->none
    //outputs product details

    require_once("Database.php");
    require_once("Util.php");

    $database = new Database();
    $con = $database->connect();

    $util = new Util();

    $title = $con->escape_string($title);
    $output = $_GET['output'];
    $available = $_GET['instock'];

    if(strtolower($title) == "all") {
      if(strtolower($available) == 'true') {
        $sql = "SELECT `title`, `price`, `inventory_count` FROM `products` WHERE inventory_count > 0";
      } else if (strtolower($available) == 'false') {
        $sql = "SELECT `title`, `price`, `inventory_count` FROM `products`";
      } else {
        echo "<h1> 400 Bad Request </h1>";
        echo "<h3> Incorrect instock format </h3>";
        die(http_response_code(400));
      }
    } else {
      $sql = "SELECT `title`, `price`, `inventory_count` FROM `products` WHERE title = '$title'";
    }

    $result = $con->query($sql);
    if($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $data[] = $row;
      }
    } else {
      echo "<h1> 400 Bad Request </h1>";
      echo "<h3> Product not found </h3>";
      die(http_response_code(400));
    }

    if(strtolower($output) == "json") {
      $util->toJSON($data);
    } else {
      echo "<h1> 400 Bad Request </h1>";
      echo "<h3> Incorrect output format </h3>";
      die(http_response_code(400));
    }
  }
}

?>
