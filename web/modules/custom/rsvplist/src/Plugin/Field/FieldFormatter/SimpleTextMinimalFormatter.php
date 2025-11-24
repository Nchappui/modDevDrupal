<?php

namespace Drupal\rsvplist\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\Annotation\FieldFormatter;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * @FieldFormatter(
 *   id = "simple_text_minimal",
 *   label = @Translation("Simple text (Minimal)"),
 *   field_types = {
 *     "simple_text"
 *   }
 * )
 */
class SimpleTextMinimalFormatter extends FormatterBase {

  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = [
        '#theme' => 'simple_text_field_minimal',
        '#value' => $item->value,
        '#attached' => [
          'library' => [
            'rsvplist/simple_text_minimal',
          ],
        ],
      ];
    }

    return $elements;
  }

}
