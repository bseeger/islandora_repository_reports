<?php

namespace Drupal\islandora_repository_reports_datasource_random_bar\Plugin\DataSource;

use Drupal\islandora_repository_reports\Plugin\DataSource\IslandoraRepositoryReportsDataSourceInterface;

/**
 * Random data source for the Islandora Repository Reports module.
 */
class Random implements IslandoraRepositoryReportsDataSourceInterface {

  /**
   * An array of arrays corresponding to CSV records.
   *
   * @var string
   */
  public $csvData;

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return t('Random data for bar charts (for testing, etc.)');
  }

  /**
   * {@inheritdoc}
   */
  public function getBaseEntity() {
    return NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function getChartType() {
    return 'bar';
  }

  /**
   * {@inheritdoc}
   */
  public function getChartTitle($total) {
    return t('@total total random data points.', ['@total' => $total]);
  }

  /**
   * {@inheritdoc}
   */
  public function getData() {
    if ($tempstore = \Drupal::service('user.private_tempstore')->get('islandora_repository_reports')) {
      if ($form_state = $tempstore->get('islandora_repository_reports_report_form_values')) {
        $num_data_elements = $form_state->getValue('islandora_repository_reports_datasource_random_bar_num_data');
      }
    }
    else {
      $num_data_elements = 5;
    }
    $chars = 'abcdefghijklmnopqrstuvwxyz';
    $data = [];
    for ($x = 1; $x <= $num_data_elements; $x++) {
      $label = ucfirst(substr(str_shuffle($chars), 3, 12));
      $data[$label] = rand(0, 100);
    }

    $this->csvData = [[t('Random data point'), 'Count']];
    foreach ($data as $label => $count) {
      $this->csvData[] = [$label, $count];
    }

    return $data;
  }

}
