<?php

$route = $_SERVER['REQUEST_URI'];

switch ($route) {
  case "/mockify":
    require_once('./src/mockify.php');
    break;
  default:
}