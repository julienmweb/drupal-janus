<?php

namespace Janus\Generate\FieldFillers;

class FieldUrlFiller implements FieldFillerInterface {

  public function fillField(&$entity, $fieldName, $fieldValue) {
    $entity->{$fieldName}['und'][]['url'] = $fieldValue;
  }
}
