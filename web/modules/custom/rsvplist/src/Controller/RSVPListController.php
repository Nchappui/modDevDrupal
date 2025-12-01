<?php

namespace Drupal\rsvplist\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Connection;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Controller for RSVP list pages and event management.
 */
class RsvpListController extends ControllerBase {

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
   * Constructs a RsvpListController object.
   *
   * @param \Drupal\Core\Database\Connection $database
   *   The database connection.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(Connection $database, EntityTypeManagerInterface $entity_type_manager) {
    $this->database = $database;
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database'),
      $container->get('entity_type.manager')
    );
  }

  /**
   * Exports all RSVP registrations to a CSV file.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   A CSV file download response.
   */
  public function export() {
    // Récupérer toutes les inscriptions
    $query = $this->database->select('rsvplist', 'r')
      ->fields('r', ['id', 'uid', 'nid', 'email', 'created'])
      ->orderBy('r.created', 'DESC');

    $results = $query->execute()->fetchAll();

    // Préparer les données CSV
    $rows = [];
    $rows[] = ['ID', 'Utilisateur', 'Événement', 'Email', 'Date']; // En-têtes

    foreach ($results as $row) {
      $node = $this->entityTypeManager()->getStorage('node')->load($row->nid);
      $user = $this->entityTypeManager()->getStorage('user')->load($row->uid);

      $rows[] = [
        $row->id,
        $user ? $user->getDisplayName() : 'Utilisateur supprimé',
        $node ? $node->label() : 'Nœud supprimé',
        $row->email,
        date('d/m/Y H:i', $row->created),
      ];
    }

    // Créer le fichier CSV
    $handle = fopen('php://temp', 'r+');
    foreach ($rows as $row) {
      fputcsv($handle, $row, ';'); // Séparateur point-virgule pour Excel
    }
    rewind($handle);
    $csv = stream_get_contents($handle);
    fclose($handle);

    // Retourner en tant que téléchargement
    $response = new \Symfony\Component\HttpFoundation\Response($csv);
    $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
    $response->headers->set('Content-Disposition', 'attachment; filename="rsvp-export-' . date('Y-m-d') . '.csv"');

    return $response;
  }

  /**
   * Displays details of a specific RSVP registration.
   *
   * @param int $rsvp_id
   *   The RSVP registration ID.
   *
   * @return array
   *   A render array containing the registration details.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
   *   If the registration does not exist.
   */
  public function details($rsvp_id) {
    $rsvp = $this->database->select('rsvplist', 'r')
      ->fields('r')
      ->condition('r.id', $rsvp_id)
      ->execute()
      ->fetchObject();

    if (!$rsvp) {
      throw new NotFoundHttpException();
    }

    $node = $this->entityTypeManager->getStorage('node')->load($rsvp->nid);
    $user = $this->entityTypeManager->getStorage('user')->load($rsvp->uid);

    return [
      '#theme' => 'item_list',
      '#title' => $this->t('Détails de l\'inscription #@id', ['@id' => $rsvp_id]),
      '#items' => [
        $this->t('Email : @email', ['@email' => $rsvp->email]),
        $this->t('Utilisateur : @name', ['@name' => $user ? $user->getDisplayName() : $this->t('Inconnu')]),
        $this->t('Événement : @title', ['@title' => $node ? $node->label() : $this->t('Inconnu')]),
        $this->t('Date : @date', ['@date' => date('d/m/Y H:i', $rsvp->created)]),
      ],
      '#cache' => [
        'tags' => ['rsvplist:' . $rsvp_id],
      ],
    ];
  }


  /**
   * Lists all events with RSVP registrations.
   *
   * @param \Drupal\node\NodeInterface|null $node
   *   (optional) A specific node to show registrations for.
   *
   * @return array
   *   A render array containing the event list or specific event registrations.
   */
  public function eventList(NodeInterface $node = NULL) {
    $build = [];

    if ($node) {
      // Afficher les inscriptions pour un nœud spécifique
      $count = $this->database->select('rsvplist', 'r')
        ->condition('r.nid', $node->id())
        ->countQuery()
        ->execute()
        ->fetchField();

      $build['info'] = [
        '#markup' => $this->t('<p>@count inscription(s) pour <strong>@title</strong></p>', [
          '@count' => $count,
          '@title' => $node->label(),
        ]),
      ];
    }
    else {
      // Afficher tous les événements
      $query = $this->database->select('rsvplist', 'r');
      $query->fields('r', ['nid']);
      $query->addExpression('COUNT(*)', 'count');
      $query->groupBy('r.nid');
      $query->orderBy('count', 'DESC');

      $results = $query->execute()->fetchAll();

      $items = [];
      foreach ($results as $row) {
        $node = $this->entityTypeManager()->getStorage('node')->load($row->nid);
        if ($node) {
          $items[] = $this->t('@title : @count inscription(s)', [
            '@title' => $node->toLink()->toString(),
            '@count' => $row->count,
          ]);
        }
      }

      $build['list'] = [
        '#theme' => 'item_list',
        '#title' => $this->t('Événements avec inscriptions'),
        '#items' => $items,
        '#empty' => $this->t('Aucun événement avec inscriptions.'),
      ];
    }

    return $build;
  }

}
