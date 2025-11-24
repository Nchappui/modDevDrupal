<?php

namespace Drupal\rsvplist\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Connection;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Contrôleur pour les pages RSVP.
 */
class RsvpListController extends ControllerBase {

  /**
   * Service de base de données.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * {@inheritdoc}
   */
  public function __construct(Connection $database) {
    $this->database = $database;
  }

  /**
   * Exporter les inscriptions au format CSV.
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
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }

  /**
   * Page de rapport : Liste toutes les inscriptions.
   */
  public function report() {
    // Récupérer toutes les inscriptions
    $query = $this->database->select('rsvplist', 'r')
      ->fields('r', ['id', 'uid', 'nid', 'email', 'created'])
      ->orderBy('r.created', 'DESC')
      ->range(0, 50);

    $results = $query->execute()->fetchAll();

    // Construire le tableau HTML
    $rows = [];
    foreach ($results as $row) {
      $node = $this->entityTypeManager()->getStorage('node')->load($row->nid);
      $user = $this->entityTypeManager()->getStorage('user')->load($row->uid);

      $rows[] = [
        $row->id,
        $node ? $node->toLink()->toString() : $this->t('Nœud supprimé'),
        $user ? $user->toLink()->toString() : $this->t('Utilisateur supprimé'),
        $row->email,
        $this->t('@time ago', ['@time' => \Drupal::service('date.formatter')->formatInterval(time() - $row->created)]),
      ];
    }

    return [
      '#theme' => 'table',
      '#header' => [
        $this->t('ID'),
        $this->t('Événement'),
        $this->t('Utilisateur'),
        $this->t('Email'),
        $this->t('Date d\'inscription'),
      ],
      '#rows' => $rows,
      '#empty' => $this->t('Aucune inscription pour le moment.'),
      '#cache' => [
        'max-age' => 300,
        'tags' => ['rsvplist_list'],
      ],
    ];
  }


  /**
   * Détails d'une inscription spécifique.
   *
   * @param int $rsvp_id
   *   ID de l'inscription.
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

    $node = $this->entityTypeManager()->getStorage('node')->load($rsvp->nid);
    $user = $this->entityTypeManager()->getStorage('user')->load($rsvp->uid);

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
   * Liste des événements avec inscriptions.
   *
   * @param \Drupal\node\NodeInterface|null $node
   *   Nœud optionnel (conversion automatique depuis l'URL).
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
