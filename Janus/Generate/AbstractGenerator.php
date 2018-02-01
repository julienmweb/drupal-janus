<?php

namespace Janus\Generate;

use Janus\Generate\FieldFillers\FieldTextFiller;
use Janus\Generate\FieldFillers\FieldIntFiller;
use Janus\Generate\FieldFillers\FieldEmailFiller;
use Janus\Generate\FieldFillers\FieldDateFiller;
use Janus\Generate\FieldFillers\FieldPropertyFiller;
use Janus\Generate\FieldFillers\FieldTaxoFiller;
use Janus\Generate\FieldFillers\FieldFileFiller;
use Janus\Generate\FieldFillers\FieldUrlFiller;

abstract class AbstractGenerator {

  protected $textFiller;
  protected $intFiller;
  protected $emailFiller;
  protected $dateFiller;
  protected $fileFiller;
  protected $urlFiller;
  protected $propertyFiller;
  protected $taxoFiller;
  protected $data;
  protected $entity;
  protected $fieldList;

  public function __construct() {
    $this->textFiller         = new FieldTextFiller();
    $this->intFiller          = new FieldIntFiller();
    $this->emailFiller        = new FieldEmailFiller();
    $this->dateFiller         = new FieldDateFiller();
    $this->propertyFiller = new FieldPropertyFiller();
    $this->taxoFiller         = new FieldTaxoFiller();
    $this->fileFiller         = new FieldFileFiller();
    $this->urlFiller          = new FieldUrlFiller();
  }

  protected function fillFields($fillerType) {
    switch ($fillerType) {
      case "textFiller":
      case "intFiller":
      case "emailFiller":
      case "dateFiller":
      case "fileFiller":
      case "urlFiller":
        $this->fillWith($fillerType);
        break;
      case "propertyFiller":
        $this->fillPropertyFields();
        break;
      case "taxoFiller":
        $this->fillTaxoFields();
        break;
      default:
        echo htmlspecialchars($fillerType)."does not exists\n";
    }
  }

  private function fillWith($filler) {
    $fieldList = !empty($this->fieldList[$filler]) ? $this->fieldList[$filler] : [];
    foreach ($fieldList as $value) {
      if (!empty($this->data[$value])) {
        if (!\is_array($this->data[$value])) {
          $this->data[$value] = (array) $this->data[$value];
        }
        foreach ($this->data[$value] as $dataValue) {
          $this->{$filler}->fillField($this->entity, $value, $dataValue);
        }
      }
    }
  }

  protected function fillPropertyFields() {
    $fieldPropertyList = !empty($this->fieldList['propertyFiller']) ? $this->fieldList['propertyFiller'] : [];
    foreach ($fieldPropertyList as $property) {
      if (!empty($this->data[$property])) {
        $this->propertyFiller->fillField($this->entity, $property, $this->data[$property]);
      }
    }
  }

  protected function fillTaxoFields() {
    $fieldTaxoList = !empty($this->fieldList['taxoFiller']) ? $this->fieldList['taxoFiller'] : [];
    foreach ($fieldTaxoList as $vocabName => $taxo) {
      if (!empty($this->data[$taxo])) {
        if (!\is_array($this->data[$taxo])) {
          $this->data[$taxo] = (array) $this->data[$taxo];
        }
        foreach ($this->data[$taxo] as $taxoValue) {
          if (!empty($taxoValue)) {
            $this->taxoFiller->createTermIfNotExists($taxoValue, $vocabName);
            $term = $this->taxoFiller->getTerm($taxoValue, $vocabName);
            $tid  = current($term)->tid;
            $this->taxoFiller->fillField($this->entity, $taxo, $tid);
          }
        }
      }
    }
  }

}