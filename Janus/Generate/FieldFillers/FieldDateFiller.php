<?php

namespace Janus\Generate\FieldFillers;

class FieldDateFiller implements FieldFillerInterface {

  public function fillField(&$entity, $fieldName, $fieldValue) {
    $entity->{$fieldName}['und'][]['value'] = $fieldValue;
  }
}
