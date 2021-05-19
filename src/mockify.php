<?php

$text = $_POST['text'];
const MAX_CONSECUTIVE_TYPE = 3;

function clapify($text) {
  $first = explode(" ", $text)[0];
  return $first === 'clapify';
}

function shopify($text) {
  $first = explode(" ", $text)[0];
  return $first === 'shopify';
}

function debinify($text) {
  $first = explode(" ", $text)[0];
  return $first === 'debinify';
}

function binify($text) {
  $first = explode(" ", $text)[0];
  return $first === 'binify';
}

function flagify($text) {
  $first = explode(" ", $text)[0];
  return $first === 'flagify';
}

if (clapify($text)) {
  
  $deClapifiedString = substr($text, 8);
  $clapifiedString = str_replace(' ', ':clap:', $deClapifiedString) . ':clap:';
  $returnText = strtoupper($clapifiedString);
  
}
else if (shopify($text)) {
  
  $deShopifiedString = substr($text, 8);
  $returnText = 'lettuce turnip the beets';
  
}
else if (binify($text)) {
  
  $string = substr($text, 7);
  $characters = str_split($string);

  $binary = [];
  foreach ($characters as $character) {
    $data = unpack('H*', $character);
    $binary[] = base_convert($data[1], 16, 2);
  }

  $returnText = 'Binification: ' . implode(' ', $binary);
  
}
else if (debinify($text)) {
  
  $binString = substr($text, 9);
  $string = '';
  $binaries = explode(' ', $binString);
  
  foreach ($binaries as $binary) {
    $string .= pack('H*', dechex(bindec($binary)));
  }
  
  $returnText = 'Debinification: ' . $string;
  
}
else if (flagify($text)) {
  
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

  $returnText = $message;

}
else {
 
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

  $returnText = implode($mockifiedArray);
  
}

header('Content-type: application/json');
$response = [
  'response_type' => 'in_channel',
  // 'response_type' => 'ephemeral',
  'text' => $returnText,
];

echo json_encode($response);
