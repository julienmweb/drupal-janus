<?php

namespace Janus\Generate\FieldFillers;

class FieldTextFiller implements FieldFillerInterface {

  public function fillField(&$entity, $fieldName, $fieldValue) {
    $entity->{$fieldName}['und'][]['value'] = $fieldValue;
    $entity->{$fieldName}['und'][]['format'] = 'filtered_html';
  }
}