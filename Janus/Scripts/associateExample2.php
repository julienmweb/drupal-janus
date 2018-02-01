<?php

use Janus\EntityAssociator;
use Janus\CSVParser;

///// PARSE DATA /////
$crossReferenceTable = [
  'client number' => 'field_client_number',
  'email' => 'field_janus_email',
];

$csvParser  = new CSVParser();
$parsedData = $csvParser->getParsedCSV(NODES_CSV_FILES, ';', $crossReferenceTable);


///// ASSOCIATE NODES /////
$entityAssociator = new EntityAssociator();
foreach ($parsedData as $data) {
  //// Associate user ON another_content_type /////
  $entity = [
    'entity_type' => 'node',
    'bundle' => 'another_content_type',
    'select_by_fields' => [
      'field_client_number' => [
        'column' => 'value',
        'value' => $data['field_client_number'],
      ],
    ],
  ];

  $entityAssociated = [
    'entity_type' => 'user',
    'field_entity_reference_name' => 'field_users',
    'select_by_properties' => [
      'mail' => $data['field_janus_email'],
    ],
  ];
  $entityAssociator->associateEntities($entity, $entityAssociated);
}