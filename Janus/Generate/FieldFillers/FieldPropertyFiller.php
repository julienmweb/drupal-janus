<?php

namespace Janus\Generate\FieldFillers;

class FieldPropertyFiller implements FieldFillerInterface {

  public function fillField(&$entity, $fieldName, $fieldValue) {
    $entity->{$fieldName} = $fieldValue;
  }
}
