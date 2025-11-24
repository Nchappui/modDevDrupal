<?php

namespace Drupal\rsvplist\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class RSVPForm extends FormBase
{

  /**
   * @inheritDoc
   */
  public function getFormId()
  {
    return 'rsvplist_email_form';
  }

  /**
   * @inheritDoc
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $node = \Drupal::routeMatch()->getParameter('node');
    if (!(is_null($node))) {
      $nid = $node->id();
    } else {
      $nid = 0;
    }

    $form['nid'] = [
      '#type' => 'hidden',
      '#value' => $nid,
    ];
    $form['email'] = [
      '#type' => 'email',
      '#title' => 'Email',
      '#required' => TRUE,
      '#size' => 60,
      '#description' => t('Please enter your email address.'),
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Submit',
    ];
    return $form;
  }

  /**
   * @inheritDoc
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    try {
      $email = $form_state->getValue('email');
      $nid = $form_state->getValue('nid');
      $uid = \Drupal::currentUser()->id();
      $current_time = \Drupal::time()->getRequestTime();

      //\Drupal::messenger()->addMessage($this->t('The node id after submit is @nid.', ['@nid' => $nid]));

      $query = \Drupal::database()->insert('rsvplist')
        ->fields(['uid' => $uid, 'email' => $email, 'nid' => $nid, 'created' => $current_time]);
      $query->execute();

      \Drupal::messenger()->addMessage($this->t('Thank you! Your email @email has been registered.', ['@email' => $email]));
    } catch (\Exception $exception) {
      \Drupal::messenger()->addError($this->t('An error occurred: @error', ['@error' => $exception->getMessage()]));
    }
  }

  /**
   * @inheritdoc
   */
  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    $submittedEmail = $form_state->getValue('email');
    if (!(\Drupal::service('email.validator')->isValid($submittedEmail))) {
      $form_state->setErrorByName('email', $this->t('Invalid email address.'));
    }
  }
}
