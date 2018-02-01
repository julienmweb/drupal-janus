<?php

namespace Janus\Generate\FieldFillers;

class FieldIntFiller implements FieldFillerInterface {

  public function fillField(&$entity, $fieldName, $fieldValue) {
    $entity->{$fieldName}['und'][]['value'] = $fieldValue;
  }
}