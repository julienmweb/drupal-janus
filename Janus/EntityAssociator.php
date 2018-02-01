<?php

namespace Janus;

class EntityAssociator {

  private $entity;
  private $entityInfo;
  private $entityAssociated;
  private $entityAssociatedInfo;

  public function associateEntities($entityInfo, $entityAssociatedInfo) {
    $this->entityInfo           = $entityInfo;
    $this->entityAssociatedInfo = $entityAssociatedInfo;
    $this->setEntities();
    $this->associate();
  }

  private function setEntities() {
    $this->entity           = $this->loadEntity($this->entityInfo);
    $this->entityAssociated = $this->loadEntity($this->entityAssociatedInfo);
  }

  private function loadEntity($info) {
    $entity               = [];
    $select_by_fields     = !empty($info['select_by_fields']) ? $info['select_by_fields'] : [];
    $select_by_properties = !empty($info['select_by_properties']) ? $info['select_by_properties'] : [];
    $query                = new \EntityFieldQuery();
    $query->entityCondition('entity_type', $info['entity_type']);
    if (!empty($info['bundle'])) {
      $query->entityCondition('bundle', $info['bundle']);
    }

    foreach ($select_by_fields as $field_name => $field_data) {
      $query->fieldCondition($field_name, $field_data['column'], $field_data['value']);
    }
    foreach ($select_by_properties as $prop_name => $prop_value) {
      $query->propertyCondition($prop_name, $prop_value);
    }
    $results = $query->execute();

    if (!empty($results[$info['entity_type']])) {
      if ($info['entity_type'] === 'node') {
        $entities = node_load_multiple(array_keys($results[$info['entity_type']]));
      }
      else {
        if ($info['entity_type'] === 'user') {
          $entities = user_load_multiple(array_keys($results[$info['entity_type']]));
        }
      }
      if (count($entities) === 1) {
        $entity = current($entities);
      }
      else {
        if (count($entities) > 1) {
          print('---------------- ERROR: NB ENTITIES FOUND TO ASSOCIATE: ' . count($entities) . "\n");
          foreach ($entities as $entity) {
            print('---------------- ENTITIES: ' . $info['entity_type'] . ' ' . $entity->name . ' ' . $entity->nid . "\n");
          }
        }
      }
    }
    return $entity;
  }

  private function associate() {
    if (!empty($this->entity) && !empty($this->entityAssociated)) {
      $fieldName = $this->entityAssociatedInfo['field_entity_reference_name'];

      if ($this->entityInfo['entity_type'] === 'node') {
        $entityEID = $this->entity->nid;
      }
      else {
        if ($this->entityInfo['entity_type'] === 'user') {
          $entityEID = $this->entity->uid;
        }
      }
      if ($this->entityAssociatedInfo['entity_type'] === 'node') {
        $entityAssociatedEID = $this->entityAssociated->nid;
      }
      else {
        if ($this->entityAssociatedInfo['entity_type'] === 'user') {
          $entityAssociatedEID = $this->entityAssociated->uid;
        }
      }
      $this->entity->{$fieldName}['und'][]['target_id'] = $entityAssociatedEID;
      node_save($this->entity);
      print('Associated: entity ' . $entityEID . ' with entity ' . $entityAssociatedEID . "\n");
    }
  }
}