<?php

use Janus\CSVParser;
use Janus\Editor;
use Janus\Generate\NodeGenerator;

///// PARSE DATA /////
$crossReferenceTable = [
  'description' => 'body',
  'text' => 'field_janus_text',
  'name' => 'title',
  'taxo' => 'field_janus_taxo',
  'email' => 'field_janus_email',
  'url' => 'field_janus_url',
  'date' => 'field_janus_date',
  'files' => 'field_janus_file',
  'client number' => 'field_client_number',
];


$csvParser = new CSVParser();
$parsedData = $csvParser->getParsedCSV(NODES_CSV_FILES, ';', $crossReferenceTable);


///// MODIFY DATA /////
$taxoRefTable['janus_vocabulary'] = [
  'A' => 'Term A',
  'B' => 'Term B',
  'C' => 'Term C',
];
$editor = new Editor();

foreach ($parsedData as $keyData => $data) {
  $parsedData[$keyData]["title"] = ucfirst($data['title']);
  $parsedData[$keyData]['field_janus_taxo'] = $editor->formatTermList($data['field_janus_taxo'], $taxoRefTable['janus_vocabulary'], ',');
  $parsedData[$keyData]['field_janus_date'] .= '-01-01 00:00:00';
  $parsedData[$keyData]['field_janus_email'] = explode(',', $data['field_janus_email']);
  $files = explode(',', $data['field_janus_file']);
  $files = array_map(function ($file) {
    return NODES_ATTACHED_FILES_FOLDER . '/' . $file;
  },
    $files);
  $parsedData[$keyData]['field_janus_file'] = $files;
}


///// GENERATE NODES  /////
$fieldList = [
  'textFiller' => [
    'field_janus_text',
    'body',
  ],
  'emailFiller' => [
    'field_janus_email',
  ],
  'propertyFiller' => [
    'title',
  ],
  'urlFiller' => [
    'field_janus_url',
  ],
  'dateFiller' => [
    'field_janus_date',
  ],
  'fileFiller' => [
    'field_janus_file',
  ],
  'intFiller' => [
    'field_client_number',
  ],
  'taxoFiller' => [
    'janus_vocabulary' => 'field_janus_taxo',
  ],
];

$nodeGenerator = new NodeGenerator('janus', $fieldList);

foreach ($parsedData as $data) {
  if (!empty($data['title'])) {
    $node = $nodeGenerator->generateNode($data);
  }
}
