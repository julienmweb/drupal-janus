<?php

use Janus\CSVParser;
use Janus\Generate\UserGenerator;

///// PARSE DATA /////
$crossReferenceTable = [
  'mail' => 'mail',
  'last name' => 'field_last_name',
  'first name' => 'field_first_name',
];

$csvParser = new CSVParser();
$parsedData = $csvParser->getParsedCSV(USERS_CSV_FILES, ';', $crossReferenceTable);

///// MODIFY DATA /////
foreach ($parsedData as $key => $data) {
  $parsedData[$key]["name"] = strtolower($data['field_first_name']) . ' ' . strtolower($data['field_last_name']);
  $parsedData[$key]["field_last_name"] = ucfirst($data['field_last_name']);
  $parsedData[$key]["field_first_name"] = ucfirst($data['field_first_name']);
}


///// GENERATE USERS  /////
$fieldList = [
  'fieldPropertyList' => [
    'name',
    'mail',
  ],
  'fieldTextList' => [
    'field_last_name',
    'field_first_name',
  ],
];
$userGenerator = new UserGenerator($fieldList);
foreach ($parsedData as $data) {
  if (!empty($data['mail'])) {
    $userGenerator->createOrUpdateUser($data);
  }
}
