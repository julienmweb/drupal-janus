<?php

namespace Janus\Generate;

class UserGenerator extends AbstractGenerator {

  protected $fieldList;

  public function __construct($fieldList) {
    parent::__construct();
    $this->fieldList = $fieldList;
  }

  public function createOrUpdateUser($data) {
    $this->data = $data;
    if (empty($this->data['mail'])) {
      return print("No mail  : skipping...\n");
    }
    $this->loadUser($this->data['mail']);
    if (empty($this->entity) && empty($this->data['name'])) {
      return print("But there s no name : skipping...\n");
    }
    if (empty($this->entity)) {
      $this->data['name'] = $this->makeUniqueUsername($this->data['name']);
      $this->bootstrapUser();
    }
    $this->fillPropertyFields();
    $this->fillTextFields();
    $this->fillFileFields();
    $this->fillTaxoFields();
    $this->fillUrlFields();
    user_save($this->entity);

  }

  private function loadUser($email) {
    $account = user_load_by_mail($email);
    if (!empty($account)) {
      $this->entity = $account;
      printf("Updating user %d\n", $account->uid);
    }
    else {
      $this->entity = [];
      printf("New user\n");
    }
  }

  protected function makeUniqueUsername($name) {
    // Strip illegal characters.
    $name = preg_replace('/[^\x{80}-\x{F7} a-zA-Z0-9@_.\'-]/', '', $name);
    // Strip leading and trailing spaces.
    $name = trim($name);
    // Convert any other series of spaces to a single underscore.
    $name = preg_replace('/ +/', '_', $name);
    // If there's nothing left use a default.
    $name = ('' === $name) ? t('user') : $name;
    // Truncate to reasonable size.
    $name = (drupal_strlen($name) > (USERNAME_MAX_LENGTH - 10)) ? drupal_substr($name, 0, USERNAME_MAX_LENGTH - 11) : $name;
    // Iterate until we find a unique name.
    $i = 0;

    do {
      $newName = empty($i) ? $name : $name . '_' . $i;
      $found = db_query_range("SELECT uid from {users} WHERE name = :name", 0, 1, [':name' => $newName])->fetchAssoc();
      $i++;
    } while (!empty($found));

    return $newName;
  }

  private function bootstrapUser() {
    $this->entity = new \StdClass();
    $this->entity->pass = user_password();
    $this->entity->status = 1;
  }
}