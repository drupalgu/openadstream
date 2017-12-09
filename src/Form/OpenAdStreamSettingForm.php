<?php
namespace Drupal\openadstream\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure OpenAdStream settings for this site.
 */
class OpenAdStreamSettingForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'openadstream_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'openadstream.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('openadstream.settings');

    $form['main_settings'] = [
      '#type' => 'fieldset',
      '#title' => t('General Settings'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
      '#description' => t("These settings should be provided by 24/7 RealMedia."),
    ];

    $form['main_settings']['openadstream_hostname'] = [
      '#type' => 'textfield',
      '#title' => t('Open AdStream Hostname'),
      '#default_value' => $config->get('openadstream_hostname'),
      '#size' => 50,
      '#maxlength' => 100,
      '#description' => t('The hostname used to request ads, will be provided by 24/7 Real Media.  Do not include the initial "http://" nor any slashes, just the bare hostname.'),
      '#required' => TRUE,
    ];

    $form['main_settings']['clint_hostname'] = [
      '#type' => 'textfield',
      '#title' => t('Site Hostname'),
      '#default_value' => $config->get('clint_hostname'),
      '#size' => 50,
      '#maxlength' => 100,
      '#description' => t('By default, we will be using the current hostname'),
    ];

    $form['main_settings']['openadstream_tag'] = [
      '#type' => 'select',
      '#title' => t('Tag type'),
      '#options' => [
        'dx' => t('DX'),
      ],
      '#default_value' => $config->get('openadstream_tag'),
      '#description' => t('Select the 24/7 Real Media tag type that you want to use; the module may present different options depending on the value selected.'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration
    \Drupal::configFactory()->getEditable('openadstream.settings')
        ->set('openadstream_hostname', $form_state->getValue('openadstream_hostname'))
        ->set('clint_hostname', $form_state->getValue('clint_hostname'))
        ->set('openadstream_tag', $form_state->getValue('openadstream_tag'))
        ->save();

    parent::submitForm($form, $form_state);
  }
}
