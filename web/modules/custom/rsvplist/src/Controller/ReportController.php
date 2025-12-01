<?php

namespace Drupal\rsvplist\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller for RSVP reports and administration pages.
 */
class ReportController extends ControllerBase {

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The date formatter service.
   *
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * The messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * Constructs a ReportController object.
   *
   * @param \Drupal\Core\Database\Connection $database
   *   The database connection.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The entity type manager.
   * @param \Drupal\Core\Datetime\DateFormatterInterface $dateFormatter
   *   The date formatter service.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   */
  public function __construct(Connection $database, EntityTypeManagerInterface $entityTypeManager, DateFormatterInterface $dateFormatter, MessengerInterface $messenger) {
    $this->database = $database;
    $this->entityTypeManager = $entityTypeManager;
    $this->dateFormatter = $dateFormatter;
    $this->messenger = $messenger;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database'),
      $container->get('entity_type.manager'),
      $container->get('date.formatter'),
      $container->get('messenger')
    );
  }

  /**
   * Generates a safe link to a node.
   *
   * Accepts either a node ID or a NodeInterface object and returns
   * a rendered link if the user has access, or an error message otherwise.
   *
   * @param int|\Drupal\node\NodeInterface $nidOrNode
   *   Either a node ID or a node object.
   *
   * @return string
   *   A rendered link or an error message.
   */
  private function safeNodeLink($nidOrNode) {
    // Accepte soit un nid, soit un objet NodeInterface.
    if ($nidOrNode instanceof NodeInterface) {
      $node = $nidOrNode;
    }
    else {
      $nid = (int) $nidOrNode;
      if ($nid <= 0) {
        return $this->t('Nœud invalide');
      }
      $node = $this->entityTypeManager()->getStorage('node')->load($nid);
    }

    if ($node instanceof NodeInterface && $node->access('view')) {
      return $node->toLink()->toString();
    }

    return $this->t('Nœud introuvable ou inaccessible');
  }

  /**
   * Displays a report of all RSVP registrations.
   *
   * Shows the last 50 registrations with details about the event,
   * user, and registration date.
   *
   * @return array
   *   A render array containing the report table.
   */
  public function report() {
    $rows = [];
    try {
      $query = $this->database->select('rsvplist', 'r');
      $query->join('node_field_data', 'n', 'r.nid = n.nid');
      $query->join('users_field_data', 'u', 'r.uid = u.uid');
      $results = $query->fields('r', ['id', 'created'])
        ->fields('n', ['nid', 'title'])
        ->fields('u', ['uid', 'name'])
        ->orderBy('r.created', 'DESC')
        ->range(0, 50)
        ->execute()
        ->fetchAll();

      $nids = array_column($results, 'nid');
      $uids = array_column($results, 'uid');

      $nodes = $this->entityTypeManager->getStorage('node')->loadMultiple($nids);
      $users = $this->entityTypeManager->getStorage('user')->loadMultiple($uids);

      foreach($results as $result){
        $node = $nodes[$result->nid] ?? NULL;
        $user = $users[$result->uid] ?? NULL;
        $id_link = \Drupal\Core\Link::createFromRoute(
          $result->id,
          'rsvplist.details',
          ['rsvp_id' => $result->id]
        )->toString();
        $rows[] = [
          $id_link,
          $this->safeNodeLink($node),
          $user ? $user->toLink()->toString() : $this->t('Utilisateur supprimé'),
          $this->t('@time ago', ['@time' => $this->dateFormatter->formatInterval(time() - $result->created)]),
        ];
      }

    } catch (\Exception $e) {
      $this->messenger->addError($this->t('An error occurred: @error', ['@error' => $e->getMessage()]));
    }
    return [
      'rsvps' => [
        '#theme' => 'table',
        '#header' => [
          $this->t('ID'),
          $this->t('Événement'),
          $this->t('Utilisateur'),
          $this->t('Date d\'inscription'),
        ],
        '#rows' => $rows,
        '#empty' => $this->t('Aucune inscription pour le moment.'),
        '#cache' => [
          'max-age' => 300,
          'tags' => ['rsvplist_list'],
        ],
      ]
    ];
  }

}
