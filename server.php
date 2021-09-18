<?php

if ($_SERVER["REQUEST_METHOD"] != "GET") return;
$part = explode("api/", $_SERVER["REQUEST_URI"]);

switch ($_SERVER["REQUEST_URI"]) {
  case "/":
  case "":
    require __DIR__ . "/views/index.html";
    break;
  case "/api":
  case "/api/":
    echo json_encode((object)[
      "unix" => round(microtime(true) * 1000),
      "utc" => gmdate("D, d M Y H:i:s") . " GMT"
    ]);
    break;
  case "/api/{$part[1]}" && is_numeric($part[1]) && (int)$part[1] == $part[1]:
    echo json_encode((object)[
      "unix" => (int)$part[1],
      "utc" => gmdate("D, d M Y H:i:s", (int)$part[1] / 1000) . " GMT"
    ]);
    break;
  case "/api/{$part[1]}" && strlen(strval($part[1])) == 10:
    echo json_encode((object)[
      "unix" => strtotime($part[1]) * 1000,
      "utc" => gmdate("D, d M Y H:i:s", strtotime($part[1])) . " GMT"
    ]);
    break;
  default:
    echo "Cannot GET {$_SERVER["REQUEST_URI"]}";
}