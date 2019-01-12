<?php
  require_once("../class/Cart.php");
  require_once("../class/Api.php");

  $api = new API();
  $api->validate();

  $cart = new Cart();
  $cart->validate(2);

  $cart->display();
 ?>
