<?php

namespace Drupal\rsvplist\Form;

use Drupal\Core\Database\Connection;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Egulias\EmailValidator\EmailValidator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;

class RSVPForm extends FormBase
{
  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The database connection.
   *
   * @var Connection
   */
  protected $database;

  /**
   * The current user.
   *
   * @var AccountProxyInterface
   */
  protected $currentUser;

  /**
   * The datetime.time service.
   *
   * @var TimeInterface
   */
  protected $time;

  /**
   * The current route match.
   *
   * @var RouteMatchInterface
   */
  protected $routeMatch;

  /**
   * The messenger service.
   *
   * @var MessengerInterface
   */
  protected $messenger;

  /**
   * The email validator.
   *
   * @var EmailValidator
   */
  protected $emailValidator;

  /**
   * Constructs an RSVPForm object.
   *
   * @param Connection $database
   *   The database connection.
   * @param AccountProxyInterface $current_user
   *   The current user.
   * @param TimeInterface $time
   *   The time service.
   * @param RouteMatchInterface $route_match
   *   The current route match.
   * @param MessengerInterface $messenger
   *   The messenger service.
   * @param EmailValidator $email_validator
   *   The email validator.
   * @param EntityTypeManagerInterface $entity_type_manager
   *  The entity type manager.
   */
  public function __construct(
    Connection $database,
    AccountProxyInterface $current_user,
    TimeInterface $time,
    RouteMatchInterface $route_match,
    MessengerInterface $messenger,
    EmailValidator $email_validator,
    EntityTypeManagerInterface $entity_type_manager
  ) {
    $this->database = $database;
    $this->currentUser = $current_user;
    $this->time = $time;
    $this->routeMatch = $route_match;
    $this->messenger = $messenger;
    $this->emailValidator = $email_validator;
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database'),
      $container->get('current_user'),
      $container->get('datetime.time'),
      $container->get('current_route_match'),
      $container->get('messenger'),
      $container->get('email.validator'),
      $container->get('entity_type.manager')
    );
  }

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
    $node = $this->routeMatch->getParameter('node');
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
      $uid = $this->currentUser->id();
      $current_time = $this->time->getRequestTime();

      $query = $this->database->insert('rsvplist')
        ->fields(['uid' => $uid, 'email' => $email, 'nid' => $nid, 'created' => $current_time]);
      $query->execute();

      $this->messenger->addMessage($this->t('Thank you! Your email @email has been registered.', ['@email' => $email]));
    } catch (\Exception $exception) {
      $this->messenger->addError($this->t('An error occurred: @error', ['@error' => $exception->getMessage()]));
    }
  }

  /**
   * @inheritdoc
   */
  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    $submittedEmail = $form_state->getValue('email');
    if (!$this->emailValidator->isValid($submittedEmail)) {
      $form_state->setErrorByName('email', $this->t('Invalid email address.'));
      return;
    }
    $nid = $form_state->getValue('nid');
    $existing = $this->database->select('rsvplist', 'r')
      ->fields('r', ['id'])
      ->condition('nid', $nid)
      ->condition('email', $submittedEmail)
      ->countQuery()
      ->execute()
      ->fetchField();

    if($existing > 0){
      $form_state->setErrorByName('email', $this->t('This email address is already registered.'));
      return;
    }
    if ($nid) {
      try {
        $node = $this->entityTypeManager->getStorage('node')->load($nid);

        if (!$node) {
          $form_state->setErrorByName('', $this->t('The event you are trying to register for does not exist.'));
        }
        elseif (!$node->isPublished()) {
          $form_state->setErrorByName('', $this->t('The event you are trying to register for is not available.'));
        }
      }
      catch (\Exception $e) {
        $form_state->setErrorByName('', $this->t('An error occurred while validating the event.'));
      }
    }
    else {
      $form_state->setErrorByName('', $this->t('No event specified.'));
    }
  }
}
