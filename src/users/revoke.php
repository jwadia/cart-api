<?php
  require_once("../class/Api.php");

  $key = $_GET["apikey"];

  $api = new Api();
  $api->revoke($key);
 ?>
