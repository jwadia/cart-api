<?php
  require_once("../class/Cart.php");
  require_once("../class/Api.php");
  require_once("../class/Product.php");

  $api = new API();
  $api->validate();

  $cart = new Cart();
  $cart->validate(1);

  $title = $_GET["producttitle"];

  $product = new Product();
  $product->exists($title);

  $cart->addProduct($title);
 ?>
