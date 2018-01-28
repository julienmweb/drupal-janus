<?php

namespace Janus\Generate\FieldFillers;

interface FieldFillerInterface {

  public function fillField(&$entity, $fieldName, $fieldValue);
}
