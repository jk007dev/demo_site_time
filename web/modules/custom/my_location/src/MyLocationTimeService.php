<?php

namespace Drupal\my_location;

use Drupal\Core\Database\Driver\mysql\Connection;
use Drupal\smart_ip\SmartIpLocationInterface;
use Drupal\Component\Datetime\Time;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Class MyLocationTimeService.
 */
class MyLocationTimeService {

  /**
   * Drupal\Core\Database\Driver\mysql\Connection definition.
   *
   * @var \Drupal\Core\Database\Driver\mysql\Connection
   */
  protected $database;

  /**
   * Drupal\smart_ip\SmartIpLocationInterface definition.
   *
   * @var \Drupal\smart_ip\SmartIpLocationInterface
   */
  protected $smartIpSmartIpLocation;

  /**
   * Drupal\Core\Config\ConfigManagerInterface definition.
   *
   * @var \Drupal\Core\Config\ConfigManagerInterface
   */
  protected $configManager;

  /**
   * Drupal\Core\Config\ConfigFactoryInterface definition.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructs a new DefaultService object.
   */
  public function __construct(Connection $database,
    SmartIpLocationInterface $smart_ip_smart_ip_location,
    Time $date_time,
    ConfigFactoryInterface $config_factory) {
    $this->database = $database;
    $this->smartIpSmartIpLocation = $smart_ip_smart_ip_location;
    $this->date_time = $date_time;
    $this->configFactory = $config_factory;
  }

  /**
   * Returns local time for site.
   */
  public function getSiteLocalTime() {
    $timezone = $this->configFactory->get('my_location.settings')->get('timezone');
    $current_time = $this->date_time->getCurrentTime();
    $date = new \DateTime("@" . $current_time);
    // Time in: 25th Oct 2019 - 10:30 PM format.
    $current_time_processed = $date->format('jS M Y - h:i:s A');
    return $current_time_processed;
  }

}
