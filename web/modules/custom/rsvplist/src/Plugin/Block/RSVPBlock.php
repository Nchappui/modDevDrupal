<?php

namespace Drupal\rsvplist\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\Block\Attribute\Block;
use Drupal\rsvplist\Form\RSVPForm;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\rsvplist\EnablerService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;

#[Block(
  id: "rsvp_block",
  admin_label: new TranslatableMarkup("RSVP Block")
)]

class RSVPBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The form builder service.
   *
   * @var \Drupal\Core\Form\FormBuilderInterface
   */
  protected FormBuilderInterface $formBuilder;

  /**
   * The current route match service.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected RouteMatchInterface $routeMatch;

  /**
   * The RSVP enabler service.
   *
   * @var \Drupal\rsvplist\EnablerService
   */
  protected EnablerService $enabler;

  /**
   * Constructs an RSVPBlock object.
   *
   * @param array $configuration
   *   The plugin configuration.
   * @param string $plugin_id
   *   The plugin ID.
   * @param mixed $plugin_definition
   *   The plugin definition.
   * @param \Drupal\Core\Form\FormBuilderInterface $form_builder
   *   The form builder service.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The current route match service.
   * @param \Drupal\rsvplist\EnablerService $enabler
   *   The RSVP enabler service.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    FormBuilderInterface $form_builder,
    RouteMatchInterface $route_match,
    EnablerService $enabler
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->formBuilder = $form_builder;
    $this->routeMatch = $route_match;
    $this->enabler = $enabler;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('form_builder'),
      $container->get('current_route_match'),
      $container->get('rsvplist.enabler')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $form = $this->formBuilder->getForm(RSVPForm::class);
    $some_array = [
      0 => [
        'is_active' => 'active',
        'label' => 'lorem ipsum',
        'url' => 'http://google.com',
      ],
      1 => [
        'is_active' => 'inactive',
        'label' => 'lorem ipsum',
        'url' => 'http://amazon.com',
      ],
    ];

    return [
      'part_one' => [
        $form
      ],
      'part_two' => [
        '#theme' => 'hello_block2',
        '#active_tab' => 'some_string',
        '#body_text' => [
          '#markup' => 'some_html_string',
        ],
        '#tabs' => $some_array,
        '#weight' => 0
      ],
      'part_three' => [
        '#theme' => 'hello_block',
        '#custom_data' => ['age' => '31', 'DOB' => '2 May 2000'],
        '#custom_string' => 'Hello Block!',
        '#weight' => 1
      ]
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockAccess(AccountInterface $account) {
    // If viewing a node, get the fully loaded node object.
    $node = $this->routeMatch->getParameter('node');

    if (!is_null($node)) {
      // Vérifier si le RSVP est activé pour ce node
      if ($this->enabler->isEnabled($node)) {
        return AccessResult::allowedIfHasPermission($account, 'view rsvplist');
      }
    }
    return AccessResult::forbidden();
  }

}
