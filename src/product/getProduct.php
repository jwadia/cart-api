<?php
require_once("../class/Product.php");
require_once("../class/Api.php");

$api = new API();
$api->validate();

$title = $_GET["title"];

$product = new Product();
$product->getProduct($title);
?>
