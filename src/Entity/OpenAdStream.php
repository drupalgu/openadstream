<?php

namespace Drupal\openadstream\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\openadstream\OpenAdStreamInterface;

/**
* Defines the OpenAdStream entity.
*
* @ConfigEntityType(
*   id = "openadstream",
*   label = @Translation("OpenAdStream"),
*   handlers = {
*     "list_builder" = "Drupal\openadstream\Controller\OpenAdStreamListBuilder",
*     "form" = {
*       "add" = "Drupal\openadstream\Form\OpenAdStreamForm",
*       "edit" = "Drupal\openadstream\Form\OpenAdStreamForm",
*       "delete" = "Drupal\openadstream\Form\OpenAdStreamDeleteForm",
*     }
*   },
*   config_prefix = "openadstream",
*   admin_permission = "administer site configuration",
*   entity_keys = {
*     "id" = "id",
*     "label" = "label",
*   },
*   links = {
*     "edit-form" = "/admin/config/services/openadstream/{openadstream}",
*     "delete-form" = "/admin/config/services/openadstream/{openadstream}/delete",
*   }
* )
*/
class OpenAdStream extends ConfigEntityBase implements OpenAdStreamInterface {

/**
* The Example ID.
*
* @var string
*/
public $id;

/**
* The OpenAdStream label.
*
* @var string
*/
public $label;

// Your specific configuration property get/set methods go here,
// implementing the interface.
}
