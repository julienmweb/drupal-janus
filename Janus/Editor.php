<?php

namespace Janus;

class Editor {

  public function formatTermList($termList, $taxoRefTable, $delimiter = ',') {
    $termList = explode($delimiter, $termList);
    foreach ($termList as $keyTerm => $valueTerm) {
      $termList[$keyTerm] = $this->replaceAcronymeByName(strtoupper(trim($valueTerm)), $taxoRefTable);
    }
    return $termList;
  }

  public function replaceAcronymeByName($valueTerm, $taxoRefTable) {
    if (array_key_exists($valueTerm, $taxoRefTable)) {
      $data = $taxoRefTable[$valueTerm];
    }
    else {
      $data = $valueTerm;
    }
    return $data;
  }
}
