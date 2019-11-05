<?php

namespace Drupal\my_location\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure My Location settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'my_location_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['my_location.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['#title'] = 'Site Local Location';
    $form['country'] = [
      '#type' => 'textfield',
      '#required' => TRUE,
      '#title' => $this->t('Country'),
      '#default_value' => $this->config('my_location.settings')->get('country'),
    ];
    $form['city'] = [
      '#type' => 'textfield',
      '#required' => TRUE,
      '#title' => $this->t('City'),
      '#default_value' => $this->config('my_location.settings')->get('city'),
    ];
    $form['timezone'] = [
      '#type' => 'select',
      '#title' => $this->t('Timezone'),
      '#options' => [
        'America/Chicago' => 'Chicago',
        'America/New_York' => 'New_York',
        'Asia/Tokyo' => 'Tokyo',
        'Asia/Dubai' => 'Dubai',
        'Asia/Kolkata' => 'Kolkata',
        'Europe/Amsterdam' => 'Amsterdam',
        'Europe/Oslo' => 'Oslo',
        'Europe/London' => 'London',
      ],
      '#default_value' => $this->config('my_location.settings')->get('timezone'),
    ];
    // $form['tz'] = [
    // '#type' => 'tzfield',
    // '#title' => $this->t('Timezone'),
    // '#default_value' => $this->config('my_location.settings')->get('tz'),
    // ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if ($form_state->getValue('country') == '' && $form_state->getValue('city') == '') {
      $form_state->setErrorByName('country', $this->t('The value is not correct.'));
      $form_state->setErrorByName('city', $this->t('The value is not correct.'));
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('my_location.settings')
      ->set('country', $form_state->getValue('country'))
      ->set('city', $form_state->getValue('city'))
      ->set('timezone', $form_state->getValue('timezone'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
