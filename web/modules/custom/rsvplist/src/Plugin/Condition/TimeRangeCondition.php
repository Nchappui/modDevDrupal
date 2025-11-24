<?php


namespace Drupal\rsvplist\Plugin\Condition;

use Drupal\Core\Condition\ConditionPluginBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Affiche le block seulement pendant une plage horaire.
 *
 * @Condition(
 *   id = "time_range_condition",
 *   label = @Translation("Plage horaire"),
 * )
 */
class TimeRangeCondition extends ConditionPluginBase
{

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration()
  {
    return [
        'start_time' => '09:00',
        'end_time' => '17:00',
      ] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state)
  {
    $form['start_time'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Heure de début'),
      '#description' => $this->t('Format HH:MM (ex: 09:00)'),
      '#default_value' => $this->configuration['start_time'],
      '#required' => TRUE,
    ];

    $form['end_time'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Heure de fin'),
      '#description' => $this->t('Format HH:MM (ex: 17:00)'),
      '#default_value' => $this->configuration['end_time'],
      '#required' => TRUE,
    ];

    return parent::buildConfigurationForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state)
  {
    $this->configuration['start_time'] = $form_state->getValue('start_time');
    $this->configuration['end_time'] = $form_state->getValue('end_time');
    parent::submitConfigurationForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function evaluate()
  {
    $current_time = date('H:i');
    $start = $this->configuration['start_time'];
    $end = $this->configuration['end_time'];

    return ($current_time >= $start && $current_time <= $end);
  }

  /**
   * {@inheritdoc}
   */
  public function summary()
  {
    return $this->t('Afficher entre @start et @end', [
      '@start' => $this->configuration['start_time'],
      '@end' => $this->configuration['end_time'],
    ]);
  }

}
