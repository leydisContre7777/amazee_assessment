<?php

/**
 * @file
 * Contains \Drupal\amazee_assessment\Token\MultiplyToken.
 */

namespace Drupal\amazee_assessment\Token;

/**
 * Token class for the '*' operator.
 */
class MultiplyToken extends BaseToken implements OperatorTokenInterface {

  /**
   * {@inheritdoc}
   */
  public function getPrecedence() {
    return 1;
  }

  /**
   * {@inheritdoc}
   */
  public function getAssociativity() {
    return OperatorTokenInterface::ASSOCIATIVITY_LEFT;
  }

  /**
   * {@inheritdoc}
   */
  public function execute(&$stack) {
    $a = array_pop($stack);
    $b = array_pop($stack);
    $result = $b->getValue() * $a->getValue();
    return new NumberToken($b->getOffset(), $result);
  }

}
