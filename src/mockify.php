<?php

$text = 'flagify 88hello';
const MAX_CONSECUTIVE_TYPE = 3;
// $text = "t e s t i n g a l o n g e r s e n t e n c e!";
// var_dump($text); die;
$FLAG_CODES = [
  'AD',
  'AE',
  'AF',
  'AG',
  'AI',
  'AL',
  'AM',
  'AO',
  'AQ',
  'AR',
  'AS',
  'AT',
  'AU',
  'AW',
  'AX',
  'AZ',
  'BA',
  'BB',
  'BD',
  'BE',
  'BF',
  'BG',
  'BH',
  'BI',
  'BJ',
  'BL',
  'BM',
  'BN',
  'BO',
  'BQ',
  'BR',
  'BS',
  'BT',
  'BV',
  'BW',
  'BY',
  'BZ',
  'CA',
  'CC',
  'CD',
  'CF',
  'CG',
  'CH',
  'CI',
  'CK',
  'CL',
  'CM',
  'CN',
  'CO',
  'CR',
  'CU',
  'CV',
  'CW',
  'CX',
  'CY',
  'CZ',
  'DE',
  'DJ',
  'DK',
  'DM',
  'DO',
  'DZ',
  'EC',
  'EE',
  'EG',
  'EH',
  'ER',
  'ES',
  'ET',
  'FI',
  'FJ',
  'FK',
  'FM',
  'FO',
  'FR',
  'GA',
  'GB',
  'GD',
  'GE',
  'GF',
  'GG',
  'GH',
  'GI',
  'GL',
  'GM',
  'GN',
  'GP',
  'GQ',
  'GR',
  'GS',
  'GT',
  'GU',
  'GW',
  'GY',
  'HK',
  'HM',
  'HN',
  'HR',
  'HT',
  'HU',
  'ID',
  'IE',
  'IL',
  'IM',
  'IN',
  'IO',
  'IQ',
  'IR',
  'IS',
  'IT',
  'JE',
  'JM',
  'JO',
  'JP',
  'KE',
  'KG',
  'KH',
  'KI',
  'KM',
  'KN',
  'KP',
  'KR',
  'KW',
  'KY',
  'KZ',
  'LA',
  'LB',
  'LC',
  'LI',
  'LK',
  'LR',
  'LS',
  'LT',
  'LU',
  'LV',
  'LY',
  'MA',
  'MC',
  'MD',
  'ME',
  'MF',
  'MG',
  'MH',
  'MK',
  'ML',
  'MM',
  'MN',
  'MO',
  'MP',
  'MQ',
  'MR',
  'MS',
  'MT',
  'MU',
  'MV',
  'MW',
  'MX',
  'MY',
  'MZ',
  'NA',
  'NC',
  'NE',
  'NF',
  'NG',
  'NI',
  'NL',
  'NO',
  'NP',
  'NR',
  'NU',
  'NZ',
  'OM',
  'PA',
  'PE',
  'PF',
  'PG',
  'PH',
  'PK',
  'PL',
  'PM',
  'PN',
  'PR',
  'PS',
  'PT',
  'PW',
  'PY',
  'QA',
  'RE',
  'RO',
  'RS',
  'RU',
  'RW',
  'SA',
  'SB',
  'SC',
  'SD',
  'SE',
  'SG',
  'SH',
  'SI',
  'SJ',
  'SK',
  'SL',
  'SM',
  'SN',
  'SO',
  'SR',
  'SS',
  'ST',
  'SV',
  'SX',
  'SY',
  'SZ',
  'TC',
  'TD',
  'TF',
  'TG',
  'TH',
  'TJ',
  'TK',
  'TL',
  'TM',
  'TN',
  'TO',
  'TR',
  'TT',
  'TV',
  'TW',
  'TZ',
  'UA',
  'UG',
  'UM',
  'US',
  'UY',
  'UZ',
  'VA',
  'VC',
  'VE',
  'VG',
  'VI',
  'VN',
  'VU',
  'WF',
  'WS',
  'YE',
  'YT',
  'ZA',
  'ZM',
  'ZW',
];

function clapify($text) {
  $first = explode(" ", $text)[0];
  return $first === 'clapify';
}

function shopify($text) {
  $first = explode(" ", $text)[0];
  return $first === 'shopify';
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
else if (flagify($text)) {
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
