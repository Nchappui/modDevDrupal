<?php

namespace Drupal\rsvplist\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class RSVPConfigForm extends ConfigFormBase
{

    /**
     * @inheritDoc
     */
    protected function getEditableConfigNames()
    {
        return [
          'rsvplist.config_form'
        ];
    }

    /**
     * @inheritDoc
     */
    public function buildForm(array $form, FormStateInterface $form_state){
      $config = $this->config('rsvplist.config_form');
      $form['email'] = [
        '#type' => 'email',
        '#title' => $this->t('Email'),
        '#required' => TRUE,
        '#default_value' => $config->get('email'),
        '#description' => $this->t('The email address of the RSVP service.')
      ];
      return parent::buildForm($form, $form_state);
    }
    /**
     * @inheritDoc
     */
    public function submitForm(array &$form, FormStateInterface $form_state){
      try {
        $config = $this->config('rsvplist.config_form');
        $config->set('email', $form_state->getValue('email'))
          ->save();
        parent::submitForm($form, $form_state);
        \Drupal::messenger()->addMessage($this->t('Email saved.'));
      } catch (\Exception $e) {
        \Drupal::messenger()->addError($this->t('Error saving RSVP configuration. @error', ['@error' => $e->getMessage()]));
      }
    }

    /**
     * @inheritDoc
     */
    public function getFormId()
    {
      return 'rsvplist.config_form';
    }
}
