<?php

$text = $_POST['text'];
const MAX_CONSECUTIVE_TYPE = 3;
// $text = "t e s t i n g a l o n g e r s e n t e n c e!";
// var_dump($text); die;

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

$mockifiedText = implode($mockifiedArray);

header('Content-type: application/json');
$response = [
  'response_type' => 'in_channel',
  // 'response_type' => 'ephemeral',
  'text' => $mockifiedText,
];

echo json_encode($response);
