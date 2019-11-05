<?php

namespace Drupal\my_location\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\my_location\MyLocationTimeService;

/**
 * Provides an my_location_time block.
 *
 * @Block(
 *   id = "my_location_time",
 *   admin_label = @Translation("My Site Time"),
 *   category = @Translation("My Location")
 * )
 */
class MyLocationBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Constructs a new ExampleBlock instance.
   *
   * @param array $configuration
   *   The plugin configuration, i.e. an array with configuration values keyed
   *   by configuration option name. The special key 'context' may be used to
   *   initialize the defined contexts by setting it to an array of context
   *   values keyed by context names.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   * @param Drupal\my_location\MyLocationTimeService $my_site_time
   *   The my_location.time service.
   */
  public function __construct(array $configuration,
    $plugin_id,
    $plugin_definition,
    ConfigFactoryInterface $config_factory,
    MyLocationTimeService $my_site_time) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configFactory = $config_factory;
    $this->my_site_time = $my_site_time;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory'),
      $container->get('my_location.time')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $data = [];
    $data['localtime'] = $this->my_site_time->getSiteLocalTime();
    $data['city'] = $this->configFactory->get('my_location.settings')->get('city');
    $data['country'] = $this->configFactory->get('my_location.settings')->get('country');

    $build = [
      '#cache' => [
        // 'max-age' => 0,
        'contexts' => ['url.path', 'url.query_args', 'timezone'],
      ],
      '#title' => 'My Site Time',
      '#data' => $data,
      '#theme' => 'my_location_block',
    ];

    return $build;
  }

}
