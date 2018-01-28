<?php

namespace Janus\Generate\FieldFillers;

class FieldFileFiller implements FieldFillerInterface {

  public function fillField(&$entity, $fieldName, $fieldValue) {
    $filePath = !empty($fieldValue['file_path']) ? $fieldValue['file_path'] : $fieldValue;
    $fileDescription = !empty($fieldValue['file_description']) ? $fieldValue['file_description'] : '';
    $file = $this->saveFile($filePath, $fileDescription);
    $entity->{$fieldName}['und'][] = (array) $file;
  }

  private function saveFile($filePath, $fileDescription) {
    $path_parts = pathinfo($filePath);
    $file_path = drupal_realpath($filePath);
    $query = db_query(
      'SELECT f.fid FROM {file_managed} f WHERE f.filename = :filename',
      [':filename' => $path_parts['filename'] . '.' . $path_parts['extension']]
    )->fetchObject();

    if (!empty($query)) {
      $file = file_load($query->fid);
      // Champ display et description obligatoire sinon erreur
      $file->display = 1;
      $file->description = $fileDescription;
    }
    else {
      $file = (object) [
        'uid' => 1,
        'uri' => $file_path,
        'filemime' => file_get_mimetype($file_path),
        'status' => 1,
        'display' => 1,
        'description' => $fileDescription,
      ];

      $file = file_copy(
        $file,
        'public://',
        FILE_EXISTS_RENAME
      );
    }
    return $file;
  }
}