<?php

/**
 * @file
 * Contains \Drupal\amazee_assessment\Calculator.
 */

namespace Drupal\amazee_assessment;

use Drupal\amazee_assessment\Exception\IncorrectExpressionException;
use Drupal\amazee_assessment\ExceptionUnknownVariableException;
use Drupal\amazee_assessment\ExceptionFunctionToken;
use Drupal\amazee_assessment\Token\NumberToken;
use Drupal\amazee_assessment\Token\OperatorTokenInterface;
use Drupal\amazee_assessment\Token\VariableToken;

/**
 * Parser for mathematical expressions.
 */
class Calculator {
	/**
	 * Static cache of token streams in reverse polish (postfix) notation.
	 *
	 * @var array
	 */
	protected $tokenCache = [];

	/**
	 * Constructs a new Calculator object.
	 */
	public function __construct() {
		$this->lexer = new Lexer();
		$this->lexer
			->addOperator('plus', '\+', 'Drupal\amazee_assessment\Token\PlusToken')
			->addOperator('minus', '\-', 'Drupal\amazee_assessment\Token\MinusToken')
			->addOperator('multiply', '\*', 'Drupal\amazee_assessment\Token\MultiplyToken')
			->addOperator('division', '\/', 'Drupal\amazee_assessment\Token\DivisionToken')
			->addOperator('modulus', '\%', 'Drupal\amazee_assessment\Token\ModulusToken');

	}

	/**
	 * Calculates the result of a mathematical expression.
	 *
	 * @param string $expression
	 *   The mathematical expression.
	 *
	 * @throws \Drupal\amazee_assessment\Exception\IncorrectExpressionException
	 */
	public function calculate($expression) {
		$hash = md5($expression);
		if (isset($this->tokenCache[$hash])) {
			return $this->tokenCache[$hash];
		}

		$stream = $this->lexer->tokenize($expression);
		$tokens = $this->lexer->postfix($stream);
		$this->tokenCache[$hash] = $tokens;

		$stack = [];
		foreach ($tokens as $token) {
			if ($token instanceof NumberToken) {
				array_push($stack, $token);
			}
			elseif ($token instanceof VariableToken) {
				$identifier = $token->getValue();
			}
			elseif ($token instanceof OperatorTokenInterface || $token instanceof FunctionToken) {
				array_push($stack, $token->execute($stack));
			}
		}

		$result = array_pop($stack);

		if (!empty($stack)) {
			throw new IncorrectExpressionException();
		}

		return $result->getValue();
	}

}
