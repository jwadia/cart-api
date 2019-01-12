<?php
class Cart {
  public function create() {
    //(none)->none
    //creates new cart

    require_once("Database.php");
    require_once("Util.php");

    $database = new Database();
    $con = $database->connect();

    $util = new Util();

    $key = md5(date("Y-m-d H:i:s"));
    $output = $_GET['output'];

    $sql = "INSERT INTO carts (cartid, products) VALUES ('$key', '{}')";

    if(strtolower($output) == "json") {
      if ($con->query($sql) === TRUE) {
        $cartid["cartid"] = $key;
        $util->toJSON($cartid);
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

  public function addProduct($title) {
    //(none)->none
    //adds item to cart

    require_once("Database.php");
    require_once("Util.php");

    $database = new Database();
    $con = $database->connect();

    $util = new Util();

    $output = $_GET['output'];
    $title = $con->escape_string($title);
    $key = $con->escape_string($_GET["cartid"]);

    $sql = "SELECT * FROM `carts` WHERE cartid = '$key'";
    $result = $con->query($sql);
    if($result->num_rows > 0) {
      $row = $result->fetch_assoc();
    }

    $products = json_decode($row["products"], true);

    if(in_array($title, $products)) {
      echo "<h1> 400 Bad Request </h1>";
      echo "<h3> Product already in cart </h3>";
      die(http_response_code(400));
    } else {
      $products[] = $title;
    }

    $products = json_encode($products);

    $sql = "UPDATE carts SET products='$products' WHERE cartid='$key'";

    if(strtolower($output) == "json") {
      if ($con->query($sql) === TRUE) {
        $this->display();
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

  public function validate($status) {
    //(none)->none
    //verifies cart id

    require_once("Database.php");

    $database = new Database();
    $con = $database->connect();

    $key = $con->escape_string($_GET["cartid"]);

    $sql = "SELECT * FROM `carts` WHERE cartid = '$key' AND status < $status";
    $result = $con->query($sql);
    if($result->num_rows == 0) {
      echo "<h1> 403 Forbidden </h1>";
      echo "<h3> Incorrect cart id </h3>";
      die(http_response_code(403));
    }
  }

  public function display() {
    //(none)->none
    //display cart contents

    require_once("Database.php");
    require_once("Util.php");

    $database = new Database();
    $con = $database->connect();

    $util = new Util();

    $key = $con->escape_string($_GET["cartid"]);
    $output = $_GET['output'];

    $sql = "SELECT * FROM `carts` WHERE cartid = '$key'";
    $result = $con->query($sql);
    if($result->num_rows > 0) {
      $row = $result->fetch_assoc();
    }

    $status = $row["status"];

    $products = json_decode($row["products"], true);
    $sum = 0;

    foreach($products as $product) {
      $sql = "SELECT * FROM `products` WHERE title = '$product'";
      $result = $con->query($sql);
      if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
      }
      $sum += round($row["price"], 2);
    }

    $data["products"] = $products;
    $data["totalprice"] = "$sum";

    if($status == 0) {
      $data["status"] = "incomplete";
    } else if($status == 1) {
      $data["status"] = "complete";
    }

    if(strtolower($output) == "json") {
        $util->toJSON($data);
    }
  }

  public function complete() {
    //(none)->boolean
    //display cart contents

    require_once("Database.php");

    $database = new Database();
    $con = $database->connect();

    $key = $con->escape_string($_GET["cartid"]);
    $output = $_GET['output'];

    $sql = "SELECT * FROM `carts` WHERE cartid = '$key'";
    $result = $con->query($sql);
    if($result->num_rows > 0) {
      $row = $result->fetch_assoc();
    }

    $products = json_decode($row["products"], true);

    foreach($products as $product) {
      $sql = "SELECT * FROM `products` WHERE title = '$product'";
      $result = $con->query($sql);
      if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
      }

      $sql = "UPDATE `products` SET `inventory_count`=`inventory_count` - 1 WHERE title = '$product'";
      if ($con->query($sql) === FALSE) {
        echo "<h1> 400 Database Error </h1>";
        echo "<h3> There was an error connecting to the database </h3>";
        die(http_response_code(500));
      }
    }

    $sql = "UPDATE `carts` SET `status`= 1 WHERE cartid = '$key'";
    if ($con->query($sql) === FALSE) {
      echo "<h1> 400 Database Error </h1>";
      echo "<h3> There was an error connecting to the database </h3>";
      die(http_response_code(500));
    }

    if(strtolower($output) == "json") {
        $this->display();
    } else {
      echo "<h1> 400 Bad Request </h1>";
      echo "<h3> Incorrect output format </h3>";
      die(http_response_code(400));
    }

  }

}
?>
