<?php

/**
 * @file
 * Contains the RSVP Enabler service.
 */

namespace Drupal\rsvplist;

use Drupal\Core\Database\Connection;
use Drupal\node\Entity\Node;
use Psr\Log\LoggerInterface;

/**
 * Service to manage RSVP enabling/disabling on nodes.
 */
class EnablerService
{
  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database_connection;

  /**
   * The logger service.
   *
   * @var LoggerInterface
   */
  protected $logger;

  /**
   * Constructs an EnablerService object.
   *
   * @param \Drupal\Core\Database\Connection $database_connection
   *   The database connection.
   * @param \Psr\Log\LoggerInterface $logger
   *   The logger service.
   */
  public function __construct(Connection $database_connection, LoggerInterface $logger){
    $this->database_connection = $database_connection;
    $this->logger = $logger;
  }


  /**
   * Checks if an individual node is RSVP enabled.
   *
   * @param \Drupal\node\Entity\Node $node
   *   The node to check.
   *
   * @return bool|null
   *   TRUE if enabled, FALSE if not, NULL on error.
   */
  public function isEnabled(Node &$node) {
    if ($node->isNew()) {
      return FALSE;
    }
    try {
      $select = $this->database_connection->select('rsvplist_enabled', 're');
      $select->fields('re', ['nid']);
      $select->condition('nid', $node->id());
      $results = $select->execute();

      return !(empty($results->fetchCol()));
    }
    catch (\Exception $e) {
      $this->logger->error('Unable to determine RSVP settings: @message', [
        '@message' => $e->getMessage(),
      ]);
      return NULL;
    }
  }

  /**
   * Enables RSVP functionality for a node.
   *
   * @param \Drupal\node\Entity\Node $node
   *   The node to enable.
   */
  public function setEnabled(Node $node){
    try {
      if (!($this->isEnabled($node))){
        $this->database_connection->insert('rsvplist_enabled')
          ->fields(['nid' => $node->id()])
          ->execute();
      }
    }catch (\Exception $e) {
        $this->logger->error('Unable to enable RSVP for node @nid: @message', [
          '@nid' => $node->id(),
          '@message' => $e->getMessage(),
        ]);
      }
  }

  /**
   * Disables RSVP functionality for a node.
   *
   * @param \Drupal\node\Entity\Node $node
   *   The node to disable.
   */
  public function delEnabled(Node $node){
    try {
      $this->database_connection->delete('rsvplist_enabled')
        ->condition('nid', $node->id())
        ->execute();
    }  catch (\Exception $e) {
      $this->logger->error('Unable to disable RSVP for node @nid: @message', [
        '@nid' => $node->id(),
        '@message' => $e->getMessage(),
      ]);
    }
  }
}
