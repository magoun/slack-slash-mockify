<?php

$route = $_SERVER['REQUEST_URI'];

switch ($route) {
  case "/mockify":
    require_once('./src/mockify.php');
    break;
  case "/dev":
    require_once('./src/devtools.php');
    break;
  default:
}