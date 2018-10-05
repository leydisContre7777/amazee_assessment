<?php

/**
 * @file
 * Contains \Drupal\amazee_assessment\Token\BaseToken.
 */

namespace Drupal\amazee_assessment\Token;

/**
 * Abstract base class for tokens.
 */
abstract class BaseToken implements TokenInterface {

  /**
   * The offset of the token in the expression.
   *
   * @var int
   */
  protected $offset;

  /**
   * The value of the token.
   *
   * @var mixed
   */
  protected $value;

  /**
   * Returns the offset of the token in the expression.
   *
   * @return int
   *   The offset of the token.
   */
  public function getOffset() {
    return $this->offset;
  }

  /**
   * Returns the value of the token.
   *
   * @return mixed
   *   The value of the token.
   */
  public function getValue() {
    return $this->value;
  }

  /**
   * Constructs a new TokenBase object.
   *
   * @param int $offset
   *   The offset of the token in the string.
   * @param mixed $value
   *   The value of the token.
   */
  public function __construct($offset, $value) {
    $this->offset = $offset;
    $this->value = $value;
  }

}
