<?php

/**
 * @file
 * Provides html for a custom route for learning purposes.
 * Wired in mymodule.routing.yml
 */

namespace Drupal\mymodule\Controller;

use Drupal\Core\Controller\ControllerBase;

class FirstController extends ControllerBase
{
  public function simpleContent(int $pageNum): array
  {
    return [
      '#type' => 'markup',
      '#markup' => t('This is simple content for page @pageNum.', ['@pageNum' => $pageNum]),
    ];
  }
}
