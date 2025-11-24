<?php

namespace Drupal\rsvplist\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\Block\Attribute\Block;
use Drupal\rsvplist\Form\RSVPForm;

#[Block(
  id: "rsvp_block",
  admin_label: new TranslatableMarkup("RSVP Block")
)]

class RSVPBlock extends BlockBase
{

  /**
   * {@inheritdoc}
   */
  public function build()
  {
    $form = \Drupal::formBuilder()->getForm(RSVPForm::class);
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
}
