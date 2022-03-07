<?php

$text = $_POST['text'];
const MAX_CONSECUTIVE_TYPE = 3;

$first = explode(" ", $text)[0];

switch ($first) {
  case 'clapify':
    $returnText = clapify($text);
    break;
  case 'shopify':
    $returnText = shopify($text);
    break;
  case 'debinify':
    $returnText = debinify($text);
    break;
  case 'binify':
    $returnText = binify($text);
    break;
  case 'flagify':
    $returnText = flagify($text);
    break;
  case 'swearify':
    $returnText = swearify($text);
    break;
  case 'timezonify':
    $returnText = timezonify($text);
    break;
  default:
    $returnText = mockify($text);
}

function clapify($text) {
  $deClapifiedString = substr($text, 8);
  $clapifiedString = str_replace(' ', ':clap:', $deClapifiedString) . ':clap:';
  return strtoupper($clapifiedString);
}

function shopify($text) {
  $deShopifiedString = substr($text, 8);
  return 'lettuce turnip the beets';
}

function debinify($text) {
  $binString = substr($text, 9);
  $string = '';
  $binaries = explode(' ', $binString);
  
  foreach ($binaries as $binary) {
    $string .= pack('H*', dechex(bindec($binary)));
  }
  
  return 'Debinification: ' . $string;
}

function binify($text) {
  $string = substr($text, 7);
  $characters = str_split($string);

  $binary = [];
  foreach ($characters as $character) {
    $data = unpack('H*', $character);
    $binary[] = base_convert($data[1], 16, 2);
  }

  return 'Binification: ' . implode(' ', $binary);
}

function flagify($text) {
  $FLAG_CODES = require_once './assets/flag-codes.php';
  
  $text = substr($text, 8);
  function mkflag($chunk, $FLAG_CODES) {
    if (in_array(strtoupper($chunk), $FLAG_CODES)) {
      return [
        ':flag-'.strtolower($chunk).':',
        true
      ];
    } else {
      return [
        ':alphabet-white-'.strtolower(substr($chunk,0,1)).':',
        false
      ];
    }
  }

  $count = 0;
  $message = '';
  while($count < strlen($text)) {
    if (!ctype_alpha(substr($text, $count, 1))) {
      $message .= substr($text, $count, 1);
      $count++;
    }
    else if ($count + 2 < strlen($text)) {
      $res = mkflag(substr($text, $count, 2), $FLAG_CODES);
      if ($res[1]) {
        $count += 2;
      } else {
        $count++;
      }
      $message .= $res[0];
    } else {
      $message .= ':alphabet-white-'.substr($text, $count, 1).':';
      $count++;
    }
  }

  return $message;
}

function swearify($text) {
  $SWEARS = require_once './assets/clean-swears.php';
  return $SWEARS[array_rand($SWEARS)];
}

function mockify($text) {
  $stringArray = str_split($text);
  $mockifiedArray = [];

  function mockifyChar($char) {

    static $upper = 0;
    static $lower = 0;

    $upChar = function($char) use (&$upper, &$lower) {
      $upper++;
      $lower = 0;
      return strtoupper($char);
    };

    $downChar = function($char) use (&$lower, &$upper) {
      $lower++;
      $upper = 0;
      return strtolower($char);
    };

    if (preg_match('/[a-zA-Z]/', $char)) {
      if (abs($upper - $lower) >= MAX_CONSECUTIVE_TYPE) {
        return $upper > $lower ? $downChar($char) : $upChar($char);
      }
      else if (rand(0, $upper + $lower + 1) > $lower) {
        return $downChar($char);
      }
      else {
        return $upChar($char);
      }
    }
    else {
      return $char;
    }
  }

  foreach ($stringArray as $char) {
    $mockifiedArray[] = mockifyChar($char);
  }

  return implode($mockifiedArray);
}

function timezonify($text) {
  
  $input = substr($text, 11); // de-timezonify
  
  $times = [
      "pacific" => [ "offset" => -2, "name" => ["Pacific Time"] ],
      "central" => [ "offset" => 0, "name" => ["Central Time"] ],
      "eastern" => [ "offset" => 1, "name" => ["Eastern Time"] ],
      "brazil" => [ "offset" => 3, "name" => ["Brasilia Time"] ],
      "india" => [ "offset" => 11.5, "name" => ["India Time"] ]
  ];

  $output = [];
  $message = "";
  $parts = explode(" ", $input);
  $time_parts = explode(":", $parts[0]);
  if($parts[1]) {
      unset($parts[0]);
      $message = implode(" ", $parts);
  }

  foreach($times as $zone) {
      $offset = $zone["offset"];
      $working = intval($time_parts[0]) + $offset;

      if(!$working) {
          $working = 12;
      }

      $ampm = intval($working) >= 12 ? "pm" : "am";
      $minutes = ":" . $time_parts[1];

      if($working >= 24) {
          if($working > 24) {
              $working = ($working - 24);
              $ampm = "am";
          } else {
              $working = 12;
          }
      } else {
          if($working >= 12) {
              if($working > 12) {
                  $working = ($working - 12);
              }
          } else {
              $ampm = "am";
          }
      }
      if(floor($working) != $working) {
          $working = $minutes == ":00" ? floor($working) : ceil($working);
          $minutes = $minutes == ":00" ? ":30" : ":00";
      }
      $working .= $minutes . $ampm;
      $output[] = implode(", ", $zone["name"]) . ": " . $working;
  }

  if($message) {
      array_unshift($output, $message);
  }

  return implode("\n", $output);
}

// The ban hammer
// $returnText = "Stop it, Luke.";

header('Content-type: application/json');
$response = [
  'response_type' => 'in_channel',
  // 'response_type' => 'ephemeral',
  'text' => $returnText,
];

echo json_encode($response);
