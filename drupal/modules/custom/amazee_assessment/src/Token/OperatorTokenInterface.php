<?php

namespace Drupal\amazee_assessment\Token;

interface OperatorTokenInterface extends TokenInterface {

  /**
   * Right associativity operator.
   */
  const ASSOCIATIVITY_RIGHT = 'RIGHT';

  /**
   * Left associativity operator.
   */
  const ASSOCIATIVITY_LEFT = 'LEFT';

  /**
   * Returns the precedence of the operator.
   *
   * http://en.wikipedia.org/wiki/Order_of_operations
   *
   * @return int
   *   The precedence of the operator.
   *
   * @see \Drupal\amazee_assessment\Lexer::postfix()
   */
  public function getPrecedence();

  /**
   * Returns the associativity of the operator.
   *
   * http://en.wikipedia.org/wiki/Operator_associativity
   *
   * @return string
   *   The associativity of the operator.
   *
   * @see \Drupal\amazee_assessment\Lexer::postfix()
   */
  public function getAssociativity();

  /**
   * Evaluates the operator on the stack.
   *
   * @param array $stack
   *   The stack of tokens in reverse polish (postfix) notation.
   *
   * @return \Drupal\amazee_assessment\Token\NumberToken
   *   The result as a NumberToken object.
   */
  public function execute(&$stack);

}
