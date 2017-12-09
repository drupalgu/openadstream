<?php

namespace Drupal\openadstream\Plugin\Block;

use Drupal\Component\Utility\Unicode;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a generic OpenAdStream block.
 *
 * @Block(
 *   id = "openadstream_block",
 *   admin_label = @Translation("OpenAdStream"),
 *   category = @Translation("OpenAdStream"),
 *   deriver = "Drupal\openadstream\Plugin\Deriver\OpenAdStreamBlock"
 * )
 */
class OpenAdStreamBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $position = $this->getDerivativeId();
    $content['#markup'] = '<div id="oas_' . $position . '" class="oas-ad oas-' . Unicode::strtolower($position) . '"></div>';
    return $content;
  }

}
