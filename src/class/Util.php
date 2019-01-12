<?php
class Util {
  public function toJSON($array) {
    //(array)->none
    //sets header to json and prints product details in json

    header('Content-Type: application/json');
    echo json_encode($array);
  }
}

?>
