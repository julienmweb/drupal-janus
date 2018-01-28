<?php

namespace Janus\Generate\FieldFillers;

class FieldTaxoFiller implements FieldFillerInterface {

  public function fillField(&$entity, $fieldName, $fieldValue) {
    $entity->{$fieldName}['und'][]['tid'] = $fieldValue;
  }

  public function createTermIfNotExists($fieldValue, $vocabName) {
    $term = $this->getTerm($fieldValue, $vocabName);
    if (empty($term)) {
      $this->createTerm($fieldValue, $vocabName);
    }
  }

  public function getTerm($fieldValue, $vocabName = NULL) {
    $term = taxonomy_get_term_by_name($fieldValue, $vocabName);
    if (empty($term) && db_table_exists('locales_target')) {
      $term = $this->searchForTranslation($fieldValue);
    }
    return $term;
  }

  private function searchForTranslation($fieldValue) {
    $term = [];
    $query = db_select('locales_target', 'lt');
    $query->fields('lt', ['translation']);
    $query->fields('ls', ['source']);
    $query->join('locales_source', 'ls', 'ls.lid = lt.lid');
    $query->condition('lt.translation', $fieldValue, '=');

    $result = $query->execute()->fetch();
    if (!empty($result)) {
      $term = taxonomy_get_term_by_name($result->source);
    }
    return $term;
  }

  private function createTerm($name, $vocabName) {
    $vocab = taxonomy_vocabulary_machine_name_load($vocabName);
    if (!empty($vocab)) {
      $term = new \stdClass();
      $term->name = $name;
      $term->vid = $vocab->vid;
      taxonomy_term_save($term);
    }
  }

}