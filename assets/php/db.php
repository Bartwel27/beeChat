<?php

$db = array(
 "host" => "localhost:3306",
 "user" => "root",
 "pass" => "root",
 "name" => "beemessanger"
);

$db2 = array(
  "host" => $db["host"],
  "user" => $db["user"],
  "pass" => $db["pass"],
  "name" => "assets_bee_msger"
);

$connect = mysqli_connect($db["host"], $db["user"], $db["pass"], $db["name"]);
$connect2 = mysqli_connect($db2["host"], $db2["user"], $db2["pass"], $db2["name"]);

if (!$connect && !$connect2) {
  die("connection failed! ".mysqli_error($connect));
  exit();
}

?>