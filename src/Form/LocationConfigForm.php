<?php

namespace Drupal\location_info\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class LocationConfigForm.
 */
class LocationConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'location_info.locationconfig',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'location_config';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('location_info.locationconfig');
    $form['country'] = [
      '#type' => 'textfield',
      '#required' => 'true',
      '#title' => $this->t('Country'),
      '#description' => $this->t('Country Name'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('country'),
    ];
    $form['city'] = [
      '#type' => 'textfield',
      '#required' => 'true',
      '#title' => $this->t('City'),
      '#description' => $this->t('City Name'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('city'),
    ];
    $form['timezone'] = [
      '#type' => 'select',
      '#required' => 'true',
      '#title' => $this->t('Timezone'),
      '#description' => $this->t('Select Timezone'),
      '#empty_option' => '-Select-',
      '#options' => ['America/Chicago' => $this->t('America/Chicago'), 'America/New_York' => $this->t('America/New_York'), 'Asia/Tokyo' => $this->t('Asia/Tokyo'), 'Asia/Dubai' => $this->t('Asia/Dubai'), 'Asia/Kolkata' => $this->t('Asia/Kolkata'), 'Europe/Amsterdam' => $this->t('Europe/Amsterdam'), 'Europe/Oslo' => $this->t('Europe/Oslo'), 'Europe/London' => $this->t('Europe/London')],
      '#default_value' => $config->get('timezone'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('location_info.locationconfig')
      ->set('country', $form_state->getValue('country'))
      ->set('city', $form_state->getValue('city'))
      ->set('timezone', $form_state->getValue('timezone'))
      ->save();
  }

}
