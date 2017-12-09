<?php

namespace Drupal\openadstream\Plugin\Deriver;

use Drupal\Component\Plugin\Derivative\DeriverBase;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Plugin\Discovery\ContainerDeriverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides block plugin definitions for openadstream.
 *
 * @see \Drupal\openadstream\Plugin\Block\OpenAdStreamBlock
 */
class OpenAdStreamBlock extends DeriverBase implements ContainerDeriverInterface {

  /**
   * The menu storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $OpenAdStreamStorage;

  /**
   * Constructs new OpenAdStreamBlock.
   *
   * @param \Drupal\Core\Entity\EntityStorageInterface $openadstream_storage
   *   The menu storage.
   */
  public function __construct(EntityStorageInterface $openadstream_storage) {
    $this->OpenAdStreamStorage = $openadstream_storage;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, $base_plugin_id) {
    return new static(
      $container->get('entity.manager')->getStorage('openadstream')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinitions($base_plugin_definition) {
    foreach ($this->OpenAdStreamStorage->loadMultiple() as $id => $entity) {
      $this->derivatives[$id] = $base_plugin_definition;
      $this->derivatives[$id]['admin_label'] = t('OAS: @slotname', ['@slotname' => $entity->label()]);
      $this->derivatives[$id]['config_dependencies']['config'] = [$entity->getConfigDependencyName()];
    }
    return $this->derivatives;
  }

}
