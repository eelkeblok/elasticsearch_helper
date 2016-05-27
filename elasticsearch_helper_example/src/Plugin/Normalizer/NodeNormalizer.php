<?php

namespace Drupal\elasticsearch_helper_example\Plugin\Normalizer;

use Drupal\serialization\Normalizer\ContentEntityNormalizer;
use Drupal\node\Entity\Node;

/**
 * Normalizes / denormalizes Drupal nodes into an array structure good for ES.
 */
class NodeNormalizer extends ContentEntityNormalizer {

  /**
   * The interface or class that this Normalizer supports.
   *
   * @var array
   */
  protected $supportedInterfaceOrClass = ['Drupal\node\Entity\Node'];

  /**
   * Supported formats.
   *
   * @var array
   */
  protected $format = ['elasticsearch_helper'];

  /**
   * {@inheritdoc}
   */
  public function normalize($object, $format = NULL, array $context = array()) {
    /** @var Node $object */

    $data =  [
      'id' => $object->id(),
      'uuid' => $object->uuid(),
      'title' => $object->getTitle(),
      'status' => $object->isPublished(),
      'user' => [
        'name' => $object->getRevisionAuthor()->getAccountName(),
        'id' => $object->getRevisionAuthor()->id(),
      ]
    ];

    return $data;
  }
}