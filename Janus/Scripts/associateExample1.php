<?php

use Janus\EntityAssociator;
use Janus\CSVParser;
use Janus\Generate\NodeGenerator;

///// PARSE DATA /////
$crossReferenceTable = [
  'client number' => 'field_client_number',
  'name' => 'title',
];

$csvParser  = new CSVParser();
$parsedData = $csvParser->getParsedCSV(NODES_CSV_FILES, ';', $crossReferenceTable);


///// MODIFY DATA /////
foreach ($parsedData as $keyData => $data) {
  if (!empty($data['title'])) {
    $parsedData[$keyData]["title"] .= ' another content type';
  }
}

///// GENERATE NODES  /////
$fieldList = [
  'intFiller' => [
    'field_client_number',
  ],
  'propertyFiller' => [
    'title',
  ],
];

$nodeGenerator = new NodeGenerator('another_content_type', $fieldList);

foreach ($parsedData as $data) {
  if (!empty($data['title'])) {
    $node = $nodeGenerator->generateNode($data);
  }
}


///// ASSOCIATE NODES /////
$entityAssociator = new EntityAssociator();
foreach ($parsedData as $data) {
  //// Associate another_content_type ON janus /////
  $entity = [
    'entity_type' => 'node',
    'bundle' => 'janus',
    'select_by_fields' => [
      'field_client_number' => [
        'column' => 'value',
        'value' => $data['field_client_number'],
      ],
    ],
  ];

  $entityAssociated = [
    'entity_type' => 'node',
    'bundle' => 'another_content_type',
    'field_entity_reference_name' => 'field_ref_another_content_type',
    'select_by_fields' => [
      'field_client_number' => [
        'column' => 'value',
        'value' => $data['field_client_number'],
      ],
    ],
  ];
  $entityAssociator->associateEntities($entity, $entityAssociated);
}