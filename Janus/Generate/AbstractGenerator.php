<?php

namespace Janus\Generate;

use Janus\Generate\FieldFillers\FieldTextFiller;
use Janus\Generate\FieldFillers\FieldEmailFiller;
use Janus\Generate\FieldFillers\FieldDateFiller;
use Janus\Generate\FieldFillers\FieldPropertyFiller;
use Janus\Generate\FieldFillers\FieldTaxoFiller;
use Janus\Generate\FieldFillers\FieldFileFiller;
use Janus\Generate\FieldFillers\FieldUrlFiller;

abstract class AbstractGenerator {

  protected $fieldTextFiller;

  protected $fieldDateFiller;

  protected $fieldEmailFiller;

  protected $fieldTextPropertyFiller;

  protected $fieldTaxoFiller;

  protected $fieldFileFiller;

  protected $fieldUrlFiller;

  protected $data;

  protected $entity;

  public function __construct() {
    $this->fieldTextFiller = new FieldTextFiller();
    $this->fieldEmailFiller = new FieldEmailFiller();
    $this->fieldDateFiller = new FieldDateFiller();
    $this->fieldTextPropertyFiller = new FieldPropertyFiller();
    $this->fieldTaxoFiller = new FieldTaxoFiller();
    $this->fieldFileFiller = new FieldFileFiller();
    $this->fieldUrlFiller = new FieldUrlFiller();
  }

  protected function fillTextFields() {
    $fieldTextList = !empty($this->fieldList['fieldTextList']) ? $this->fieldList['fieldTextList'] : [];
    foreach ($fieldTextList as $text) {
      if (!empty($this->data[$text])) {
        $this->fieldTextFiller->fillField($this->entity, $text, $this->data[$text]);
      }
    }
  }

  protected function fillEmailFields() {
    $fieldEmailList = !empty($this->fieldList['fieldEmailList']) ? $this->fieldList['fieldEmailList'] : [];
    foreach ($fieldEmailList as $text) {
      if (!empty($this->data[$text])) {
        if (!\is_array($this->data[$text])) {
          $this->data[$text] = (array) $this->data[$text];
        }
        foreach ($this->data[$text] as $emailValue) {
          if (!empty($emailValue)) {
            $this->fieldEmailFiller->fillField($this->entity, $text, $emailValue);
          }
        }
      }
    }
  }

  protected function fillDateFields() {
    $fieldDateList = !empty($this->fieldList['fieldDateList']) ? $this->fieldList['fieldDateList'] : [];
    foreach ($fieldDateList as $date) {
      if (!empty($this->data[$date])) {
        if (!\is_array($this->data[$date])) {
          $this->data[$date] = (array) $this->data[$date];
        }
        foreach ($this->data[$date] as $dateValue) {
          $this->fieldDateFiller->fillField($this->entity, $date, $dateValue);
        }
      }
    }
  }

  protected function fillPropertyFields() {
    $fieldPropertyList = !empty($this->fieldList['fieldPropertyList']) ? $this->fieldList['fieldPropertyList'] : [];
    foreach ($fieldPropertyList as $property) {
      if (!empty($this->data[$property])) {
        $this->fieldTextPropertyFiller->fillField($this->entity, $property, $this->data[$property]);
      }
    }
  }

  protected function fillFileFields() {
    $fieldFileList = !empty($this->fieldList['fieldFileList']) ? $this->fieldList['fieldFileList'] : [];
    foreach ($fieldFileList as $file) {
      if (!empty($this->data[$file])) {
        if (!\is_array($this->data[$file])) {
          $this->data[$file] = (array) $this->data[$file];
        }
        foreach ($this->data[$file] as $fileValue) {
          $this->fieldFileFiller->fillField($this->entity, $file, $fileValue);
        }
      }
    }
  }

  protected function fillTaxoFields() {
    $fieldTaxoList = !empty($this->fieldList['fieldTaxoList']) ? $this->fieldList['fieldTaxoList'] : [];
    foreach ($fieldTaxoList as $vocabName => $taxo) {
      if (!empty($this->data[$taxo])) {
        if (!is_array($this->data[$taxo])) {
          $this->data[$taxo] = (array) $this->data[$taxo];
        }
        foreach ($this->data[$taxo] as $taxoValue) {
          if (!empty($taxoValue)) {
            $this->fieldTaxoFiller->createTermIfNotExists($taxoValue, $vocabName);
            $term = $this->fieldTaxoFiller->getTerm($taxoValue, $vocabName);
            $tid = current($term)->tid;
            $this->fieldTaxoFiller->fillField($this->entity, $taxo, $tid);
          }
        }
      }
    }
  }

  protected function fillUrlFields() {
    $fieldUrlList = !empty($this->fieldList['fieldUrlList']) ? $this->fieldList['fieldUrlList'] : [];
    foreach ($fieldUrlList as $text) {
      if (!empty($this->data[$text])) {
        if (!\is_array($this->data[$text])) {
          $this->data[$text] = (array) $this->data[$text];
        }
        foreach ($this->data[$text] as $urlValue) {
          $this->fieldUrlFiller->fillField($this->entity, $text, $urlValue);
        }
      }
    }
  }
}