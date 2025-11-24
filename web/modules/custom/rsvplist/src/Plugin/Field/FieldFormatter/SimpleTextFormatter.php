<?php

namespace Drupal\rsvplist\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\Annotation\FieldFormatter;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'simple_text_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "simple_text_formatter",
 *   label = @Translation("Simple text formatter"),
 *   field_types = {
 *     "simple_text",
 *   "string"
 *   }
 * )
 */
class SimpleTextFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = [
        '#theme' => 'simple_text_field',
        '#value' => $item->value,
        '#attached' => [
          'library' => [
            'rsvplist/simple_text_field',
          ],
        ],
      ];
    }

    return $elements;
  }

}
