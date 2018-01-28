<?php

namespace Janus\Generate\FieldFillers;

class FieldEmailFiller implements FieldFillerInterface {

  public function fillField(&$entity, $fieldName, $fieldValue) {
    $entity->{$fieldName}['und'][]['email'] = $fieldValue;
  }
}