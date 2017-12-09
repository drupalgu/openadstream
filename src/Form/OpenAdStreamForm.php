<?php

namespace Drupal\openadstream\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Entity\Query\QueryFactory;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form handler for the Example add and edit forms.
 */
class OpenAdStreamForm extends EntityForm {

  /**
   * Constructs an ExampleForm object.
   *
   * @param \Drupal\Core\Entity\Query\QueryFactory $entity_query
   *   The entity query.
   */
  public function __construct(QueryFactory $entity_query) {
    $this->entityQuery = $entity_query;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.query')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $openadstream = $this->entity;

    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Position Name'),
      '#maxlength' => 255,
      '#default_value' => $openadstream->label(),
      '#description' => $this->t("Label for the CrainOAS."),
      '#required' => TRUE,
    ];
    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $openadstream->id(),
      '#machine_name' => [
        'exists' => [$this, 'exist'],
      ],
      '#disabled' => !$openadstream->isNew(),
    ];
    $form['description'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Description'),
      '#maxlength' => 255,
      '#default_value' => isset($openadstream->description) ? $openadstream->description : '',
      '#description' => $this->t("An optional description to help remember the details of the advertisement position.."),
    ];
    if ($this->config('openadstream.settings')->get('openadstream_tag') == 'dx') {
      $form['dimensions'] = [
        '#type' => 'container',
        '#attributes' => [
          'class' => ['container-inline'],
        ],
      ];
      $form['dimensions']['width'] = [
        '#type' => 'textfield',
        '#title' => t('Width'),
        '#size' => 4,
        '#maxlength' => 4,
        '#required' => TRUE,
        '#default_value' => isset($openadstream->width) ? $openadstream->width : '',
        '#suffix' => 'px by',
      ];

      $form['dimensions']['height'] = [
        '#type' => 'textfield',
        '#title' => t('Height'),
        '#size' => 4,
        '#maxlength' => 4,
        '#required' => TRUE,
        '#default_value' => isset($openadstream->height) ? $openadstream->height : '',
        '#suffix' => 'px',
      ];
    }
    // You will need additional form elements for your custom properties.
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $openadstream = $this->entity;
    $status = $openadstream->save();

    // Invalidate the block cache to update OpenAdStream ad tag-based derivatives.
    \Drupal::service('plugin.manager.block')->clearCachedDefinitions();

    if ($status) {
      drupal_set_message($this->t('Saved the %label OpenAdStream.', ['%label' => $openadstream->label(),]));
    }
    else {
      drupal_set_message($this->t('The %label OpenAdStream was not saved.', ['%label' => $openadstream->label(),]));
    }

    $form_state->setRedirect('entity.openadstream.collection');
  }

  /**
   * Helper function to check whether an CrainOAS configuration entity exists.
   */
  public function exist($id) {
    $entity = $this->entityQuery->get('openadstream')
      ->condition('id', $id)
      ->execute();
    return (bool) $entity;
  }

}
