<?php

namespace Drupal\location_info;
use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Datetime\DateFormatterInterface;

/**
 * Class DatetimeService.
 */
class DatetimeService implements DatetimeInterface {

  /**
   * Drupal\Component\Datetime\TimeInterface definition.
   *
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  protected $datetimeTime;

  /**
   * Drupal\Core\Datetime\DateFormatterInterface definition.
   *
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * Constructs a new DatetimeService object.
   */
  public function __construct(TimeInterface $datetime_time, DateFormatterInterface $date_formatter) {
    $this->datetimeTime = $datetime_time;
    $this->dateFormatter = $date_formatter;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormattedDate($timezone,$format=NULL) {
    $date = $this->dateFormatter->format(REQUEST_TIME, 'custom', $format,$timezone);
    return $date;
  } 

}
