<?php

namespace Janus;

class CSVParser {

  private $csvConvertedInArray;

  private $parsedCSV;

  private $crossReferenceTable;

  public function getParsedCSV($csv_path, $delimiter, $crossReferenceTable) {
    if (!$this->isFileExists($csv_path)) {
      return [];
    }
    $this->convertCSVToArray($csv_path, $delimiter);
    $this->crossReferenceTable = array_change_key_case($crossReferenceTable, CASE_LOWER);
    $this->parseCSV();
    $this->removeUnwantedFields();
    $this->makeParsedCSVRowUnique();
    return $this->parsedCSV;
  }

  private function isFileExists($file_path) {
    if (file_exists($file_path)) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  private function convertCSVToArray($csv_path, $delimiter) {
    $data = new \SplFileObject($csv_path, 'r');
    $data->setFlags(\SplFileObject::READ_CSV);
    $data->setCsvControl($delimiter);
    $this->csvConvertedInArray = $data;
  }

  private function parseCSV() {
    $lineNumber = 0;
    $header = [];
    foreach ($this->csvConvertedInArray as $line) {
      $numberOfItems = count($line);
      for ($itemNumber = 0; $itemNumber < $numberOfItems; $itemNumber++) {
        if ($lineNumber == 0) {
          $header[$itemNumber] = $this->createHeader($line[$itemNumber]);
        }
        else {
          $parsedCSV[$lineNumber][$header[$itemNumber]] = trim($this->convertContentToUTF8($line[$itemNumber]));
        }
      }
      $lineNumber++;
    }
    $this->parsedCSV = $parsedCSV;
  }

  private function createHeader($headerName) {
    $headerName = mb_convert_case($this->convertContentToUTF8($headerName), MB_CASE_LOWER);
    if (array_key_exists($headerName, $this->crossReferenceTable)) {
      return $this->crossReferenceTable[$headerName];
    }
    else {
      return mb_convert_case($this->convertContentToUTF8($headerName), MB_CASE_LOWER);
    }
  }

  private function convertContentToUTF8($content) {
    return mb_convert_encoding($content, 'UTF-8',
      mb_detect_encoding($content, 'UTF-8, ISO-8859-1', TRUE)
    );
  }

  private function removeUnwantedFields() {
    foreach ($this->parsedCSV as $rowKey => $rowValue) {
      foreach ($rowValue as $fieldKey => $fieldValue) {
        if (!in_array($fieldKey, $this->crossReferenceTable)) {
          unset($this->parsedCSV[$rowKey][$fieldKey]);
        }
      }
    }
  }

  private function makeParsedCSVRowUnique() {
    $this->parsedCSV = array_map("unserialize", array_unique(array_map("serialize", $this->parsedCSV)));
  }
}