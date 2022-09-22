<?php

namespace Drupal\location_info\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactory;

/**
 * Provides a 'LocationInfoBlock' block.
 *
 * @Block(
 *  id = "location_info_block",
 *  admin_label = @Translation("Location info block"),
 * )
 */
class LocationInfoBlock extends BlockBase implements ContainerFactoryPluginInterface {

   /**
   * Configuration Factory.
   *
   * @var \Drupal\Core\Config\ConfigFactory
   */
  protected $config;

  /**
   * Drupal\location_info\DatetimeInterface definition.
   *
   * @var \Drupal\location_info\DatetimeInterface
   */
  protected $locationInfoDatetime;
  

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $instance = new static($configuration, $plugin_id, $plugin_definition);
    $instance->locationInfoDatetime = $container->get('location_info.datetime');
    $instance->config = $container->get('config.factory');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->config->get('location_info.locationconfig');
    if(empty($config->get('country'))){
      $data = null;
    }else{
      $country = $config->get('country');
      $city = $config->get('city');
      $timezone = $config->get('timezone');
      $data['date'] = $this->locationInfoDatetime->getFormattedDate(
        $timezone,'l, d F Y'
      );
      $data['time'] = $this->locationInfoDatetime->getFormattedDate($timezone, 'h:i a');
      $data['location_string'] = $this->t('Time in @city, @country',
        ['@city'=>$city,'@country'=>$country]
      );
    }
    
    $build = [];
    $build['#theme'] = 'location_info_block';
    $build['#location_detail'] = $data;
    $build['#cache'] = [
      'max-age' => 0,
    ];
    return $build;
  }

}
