<?php
// File: web/modules/custom/rsvplist/src/Plugin/Field/FieldWidget/SimpleTextWidget.php
namespace Drupal\rsvplist\Plugin\Field\FieldWidget;

use Drupal\Core\Field\Annotation\FieldWidget;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'simple_text' widget.
 *
 * @FieldWidget(
 *   id = "simple_text_widget",
 *   label = @Translation("Simple text widget"),
 *   field_types = {
 *     "simple_text"
 *   }
 * )
 */
class SimpleTextWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $value = isset($items[$delta]->value) ? $items[$delta]->value : '';

    $element += [
      '#type' => 'textfield',
      '#title' => $this->t('Texte'),
      '#default_value' => $value,
      '#size' => 60,
      '#maxlength' => 255,
    ];

    return ['value' => $element];
  }

}
