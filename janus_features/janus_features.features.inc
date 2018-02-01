<?php
/**
 * @file
 * janus_features.features.inc
 */

/**
 * Implements hook_node_info().
 */
function janus_features_node_info() {
  $items = array(
    'another_content_type' => array(
      'name' => t('another_content_type'),
      'base' => 'node_content',
      'description' => '',
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
    'janus' => array(
      'name' => t('janus'),
      'base' => 'node_content',
      'description' => '',
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
  );
  drupal_alter('node_info', $items);
  return $items;
}
