<?php

/**
 * Implements hook_views_data().
 */
function rsvplist_views_data(){
  $data = [];
  $data['rsvplist']['table']['group']  = t('RSVP List');
  $data['rsvplist']['table']['base'] = [
    'field' => 'id',
    'title' => t('RSVP List'),
    'help' => t('RSVP List table.'),
  ];
  $data['rsvplist']['id'] = [
    'title' => t('RSVP ID'),
    'help' => t('The ID of the RSVP entry.'),
    'field' => [
      'id' => 'numeric',
    ],
    'filter' => [
      'id' => 'numeric',
    ],
    'sort' => [
      'id' => 'standard',
    ],
  ];
  $data['rsvplist']['nid'] = [
    'title' => t('Node ID'),
    'help' => t('The ID of the node associated with the RSVP.'),
    'field' => [
      'id' => 'numeric',
    ],
    'filter' => [
      'id' => 'numeric',
    ],
    'sort' => [
      'id' => 'standard',
    ],
    'relationship' => [
      'title' => t('Node'),
      'help' => t('Relate RSVP to its associated node.'),
      'base' => 'node_field_data',
      'base field' => 'nid',
      'id' => 'standard',
      'label' => t('RSVP Node'),
    ],
  ];
  $data['rsvplist']['uid'] = [
    'title' => t('User ID'),
    'help' => t('The ID of the user who RSVP\'d.'),
    'field' => [
      'id' => 'numeric',
    ],
    'filter' => [
      'id' => 'numeric',
    ],
    'sort' => [
      'id' => 'standard',
    ],
    'relationship' => [
      'title' => t('User'),
      'help' => t('Relate RSVP to the user who submitted it.'),
      'base' => 'users_field_data',
      'base field' => 'uid',
      'id' => 'standard',
      'label' => t('RSVP User'),
    ],
  ];
  $data['rsvplist']['email'] = [
    'title' => t('Email'),
    'help' => t('The email address of the RSVP.'),
    'field' => [
      'id' => 'standard',
    ],
    'filter' => [
      'id' => 'string',
    ],
    'sort' => [
      'id' => 'standard',
    ],
  ];
  $data['rsvplist']['created'] = [
    'title' => t('Created date'),
    'help' => t('The date the RSVP was created.'),
    'field' => [
      'id' => 'date',
    ],
    'filter' => [
      'id' => 'date',
    ],
    'sort' => [
      'id' => 'standard',
    ],
  ];

  return $data;
}
