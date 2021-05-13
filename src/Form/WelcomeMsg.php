<?php

namespace Drupal\welcome_scott\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class WelcomeMsg.
 */
class WelcomeMsg extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'welcome_scott.welcomemsg',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'welcome_msg';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('welcome_scott.welcomemsg');
    $form['welcome_message'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Welcome Message'),
      '#description' => $this->t('Enter welcome message text here'),
      '#maxlength' => 128,
      '#size' => 64,
      '#default_value' => $config->get('welcome_message'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    // Only process if field not empty
    if ($form_state->getValue('welcome_message')) {
      parent::submitForm($form, $form_state);
      $this->config('welcome_scott.welcomemsg')
        ->set('welcome_message', $form_state->getValue('welcome_message'))
        ->save();
    } else {
      // Tell user field value needed
      drupal_set_message(t('A value for this field is required'));
    }
  }

}
