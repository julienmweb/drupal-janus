<?php

namespace Janus\Generate;

class NodeGenerator extends AbstractGenerator {

  protected $type;
  protected $language;

  public function __construct($type, $fieldList, $language = 'und') {
    parent::__construct();
    $this->type = $type;
    $this->language = $language;
    $this->fieldList = $fieldList;
  }

  public function generateNode($data, $sourceTranslationNodeID = NULL) {
    $this->data = $data;
    $this->entity = $this->createNewEmptyNode($sourceTranslationNodeID);

    $this->fillPropertyFields();
    $this->fillTaxoFields();
    foreach ($this->fieldList as $fillerType => $fields) {
      $this->fillFields($fillerType);
    }
    $this->saveNodeInDrupal();
  }

  private function createNewEmptyNode($sourceTranslationNodeID) {
    $node = new \stdClass();
    $node->type = $this->type;
    node_object_prepare($node);
    $node->language = $this->language;
    $node->uid = 1;
    $node->status = 1;
    $node->promote = 0;
    $node->comment = 0;
    if (!empty($sourceTranslationNodeID)) {
      $node->tnid = $sourceTranslationNodeID;
    }
    else {
      node_save($node);
      $node->tnid = $node->nid;
    }
    return $node;
  }

  private function saveNodeInDrupal() {
    $node = node_submit($this->entity);
    try {
      node_save($node);
    } catch (Exception $e) {
      echo $e->getMessage(), "\n";
    }
    echo "Node with NID " . $node->nid . " saved\n";
  }
}