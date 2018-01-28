<?php

use Janus\EntityAssociator;

///// PARSE DATA /////
$crossReferenceTable = array(
  'numero client' => 'field_client_number',
);
$csvParser = new CSVParser();
$parsedData = $csvParser->getParsedCSV(NODES_CSV_FILES, ';', $crossReferenceTable);


///// ASSOCIATE NODES /////
$entityAssociator = new EntityAssociator();
foreach ($parsedData as $data) {
  //// Associate content_type_2 ON content_type_1 /////
  $entity = array(
    'entity_type' => 'node',
    'bundle' => 'content_type_1',
    'select_by_fields' => array(
      'field_client_number' => array(
        'column' => 'value',
        'value' => $data['field_client_number'],
      ),
    ),
  );

  $entityAssociated = array(
    'entity_type' => 'node',
    'bundle' => 'content_type_2',
    'field_entity_reference_name' => 'field_entity_reference_janus',
    'select_by_fields' => array(
      'field_client_number' => array(
        'column' => 'value',
        'value' => $data['field_client_number'],
      ),
    ),
  );
  $entityAssociator->associateEntities($entity, $entityAssociated);
}