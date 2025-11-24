<?php
// File: web/modules/custom/rsvplist/src/Plugin/Field/FieldType/SimpleTextField.php
namespace Drupal\rsvplist\Plugin\Field\FieldType;

use Drupal\Core\Field\Annotation\FieldType;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'simple_text' field type.
 *
 * @FieldType(
 *   id = "simple_text",
 *   label = @Translation("Simple text"),
 *   description = @Translation("A very small text field storing a single string."),
 *   default_widget = "string_textfield",
 *   default_formatter = "string"
 * )
 */
class SimpleTextField extends FieldItemBase
{
  /**
   * @inheritDoc
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition)
  {
    $properties = [];
    $properties['value'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Simple text value'));
    return $properties;
  }

  /**
   * @inheritDoc
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition)
  {
    return [
      'columns' => [
        'value' => [
          'type' => 'varchar',
          'length' => 255,
        ],
      ],
      'indexes' => [
        'value' => ['value'],
      ],
    ];
  }

  /**
   * Default field settings.
   *
   * Ajoute la setting 'require_translation' visible dans l'UI d'édition du field.
   */
  public static function defaultFieldSettings()
  {
    return [
        'require_translation' => FALSE,
      ] + parent::defaultFieldSettings();
  }

  /**
   * Settings form for the field (visible in Manage fields -> Edit).
   *
   * Permet d'ajouter une checkbox pour activer/désactiver la contrainte de traduction.
   *
   * Signature compatible avec la classe parente.
   */
  public function fieldSettingsForm(array $form, FormStateInterface $form_state)
  {
    $element = [];

    $element['require_translation'] = [
      '#type' => 'checkbox',
      '#title' => new TranslatableMarkup('Champ traduisible'),
      '#description' => new TranslatableMarkup('Si coché, ce champ devra être fourni pour les langues activées.'),
      '#default_value' => $this->getSetting('require_translation'),
    ];

    return $element;
  }
}
