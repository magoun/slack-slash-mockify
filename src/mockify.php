<?php

$text = $_POST['text'];
// $text = "testing a longer sentence!";
// var_dump($text); return;

$stringArray = str_split($text);
$mockifiedArray = [];

function mockifyChar($char) {
  
  static $upper = 0;
  static $lower = 0;
  
  if (ctype_alpha($char)) {
    if (rand(0, $upper + $lower + 1) > $lower) {
      $lower += ($upper - $lower) ** 2;
      return strtolower($char);
    }
    else {
      $upper += ($upper - $lower) ** 2;
      return strtoupper($char);
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
  // 'response_type' => 'in_channel',
  'response_type' => 'ephemeral',
  'text' => $mockifiedText,
];

echo json_encode($response);
