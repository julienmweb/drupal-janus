<?php

use Janus\EntityAssociator;

///// PARSE DATA /////
$crossReferenceTable = array(
  'numero client' => 'field_client_number',
  'mail' => 'field_main_email',
);
$parsedData          = CSVParser::getParsedCSV(__DIR__ . '/data/nodes-example.csv', ';', $crossReferenceTable);


///// ASSOCIATE NODES /////
$entityAssociator = new EntityAssociator();
foreach ($parsedData as $data) {
  //// Associate user ON content_type_1 /////
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
    'entity_type' => 'user',
    'field_entity_reference_name' => 'field_entity_reference_janus',
    'select_by_properties' => array(
      'mail' => $data['field_main_email'],
    ),
  );
  $entityAssociator->associateEntities($entity, $entityAssociated);
}