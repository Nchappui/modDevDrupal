<?php

namespace Drupal\rsvplist;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Service to handle form alterations for the RSVP module.
 */
class FormAlterService {

  use StringTranslationTrait;

  /**
   * The config factory service.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The RSVP enabler service.
   *
   * @var \Drupal\rsvplist\EnablerService
   */
  protected $enabler;

  /**
   * The current user service.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * Constructs a FormAlterService object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   The config factory service.
   * @param \Drupal\rsvplist\EnablerService $enabler
   *   The RSVP enabler service.
   * @param \Drupal\Core\Session\AccountProxyInterface $currentUser
   *   The current user service.
   */
  public function __construct(ConfigFactoryInterface $configFactory, EnablerService $enabler, AccountProxyInterface $currentUser) {
    $this->configFactory = $configFactory;
    $this->enabler = $enabler;
    $this->currentUser = $currentUser;
  }

  /**
   * Alters node forms to add RSVP settings.
   *
   * Adds a checkbox to enable/disable RSVP functionality for allowed
   * content types on the node edit form.
   *
   * @param array $form
   *   The form array.
   * @param \Drupal\Core\Form\FormStateInterface $formState
   *   The form state.
   */
  public function alterNodeForm(array &$form, FormStateInterface $formState) {
    $node = $formState->getFormObject()->getEntity();
    $allowed_types = $this->configFactory->get('rsvplist.settings')->get('allowed_types');
    if (in_array($node->getType(), $allowed_types)){
      $form['rsvplist_settings'] = [
        '#type' => 'details',
        '#title' => $this->t('RSVP Settings'),
        '#access' => $this->currentUser->hasPermission('administer rsvplist'),
        '#open' => TRUE,
        '#group' => 'advanced',
        '#weight' => 100,
      ];
      $form['rsvplist_settings']['rsvplist'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Activer les inscriptions RSVP pour ce contenu'),
        '#default_value' => $this->enabler->isEnabled($node),
        '#description' => $this->t('Si coché, un formulaire RSVP sera affiché sur cette page.'),
      ];
      // Ajouter notre handler de soumission
      $form['actions']['submit']['#submit'][] = [$this, 'submitNodeForm'];
    }
  }

  /**
   * Submit handler for node forms to save RSVP settings.
   *
   * Enables or disables RSVP functionality for the node based on
   * the checkbox value.
   *
   * @param array $form
   *   The form array.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   */
  public function submitNodeForm(array &$form, FormStateInterface $form_state) {
    $node = $form_state->getFormObject()->getEntity();

    if ($form_state->getValue('rsvplist')) {
      $this->enabler->setEnabled($node);
    } else {
      $this->enabler->delEnabled($node);
    }
  }
}
