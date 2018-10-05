<?php

/**
 * @file
 * Contains \Drupal\amazee_assessment\Lexer.
 */

namespace Drupal\amazee_assessment;

use Drupal\amazee_assessment\Exception\IncorrectParenthesisException;
use Drupal\amazee_assessment\Exception\IncorrectExpressionException;
use Drupal\amazee_assessment\Exception\UnknownOperatorException;
use Drupal\amazee_assessment\Exception\UnknownTokenException;
use Drupal\amazee_assessment\Token\ParenthesisCloseToken;
use Drupal\amazee_assessment\Token\ParenthesisOpenToken;
use Drupal\amazee_assessment\Token\CommaToken;
use Drupal\amazee_assessment\Token\NumberToken;
use Drupal\amazee_assessment\Token\OperatorTokenInterface;

/**
 * Lexical analyzer for mathematical expressions.
 */
class Lexer {

	/**
	 * Static cache of the compiled regular expression.
	 *
	 * @var string
	 */
	protected $compiledRegex;

	/**
	 * The list of registered operators.
	 *
	 * @var string[]
	 */
	protected $operators = [];

	/**
	 * The list of registered constants.
	 *
	 * @var array
	 */
	protected $constants = [];

	/**
	 * The list of registered functions.
	 *
	 * @var array[]
	 */
	protected $functions = [];

	/**
	 * Registers a function with the lexer.
	 *
	 * @param string $name
	 *   The name of the function.
	 * @param callable $function
	 *   The callback to be executed.
	 * @param int $arguments
	 *   The number of arguments required for the function.
	 *
	 * @return $this
	 */
	public function addFunction($name, callable $function, $arguments = 1) {
		$this->functions[$name] = [$arguments, $function];
		return $this;
	}

	/**
	 * Registers an operator with the lexer.
	 *
	 * @param string $name
	 *   The name of the operator.
	 * @param string $regex
	 *   The regular expression of the operator token.
	 * @param string $operator
	 *   The full qualified class name of the operator token.
	 *
	 * @return $this
	 */
	public function addOperator($name, $regex, $operator) {
		if (!is_subclass_of($operator, 'Drupal\amazee_assessment\Token\OperatorTokenInterface')) {
			throw new \InvalidArgumentException();
		}

		// Clear the static cache when a new operator is added.
		unset($this->compiledRegex);

		$this->operators[$name] = [$regex, $operator];
		return $this;
	}


	/**
	 * Generates a token stream from a mathematical expression.
	 *
	 * @param string $input
	 *   The mathematical expression to tokenize.
	 *
	 * @return array
	 *   The generated token stream.
	 */
	public function tokenize($input) {
		$matches = [];
		$regex = $this->getCompiledTokenRegex();

		if (preg_match_all($regex, $input, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE) === FALSE) {
			// There was a failure when evaluating the regular expression.
			throw new \LogicException();
		};

		$types = [
			'number',
			'operator',
			'open',
			'close',
			'comma',
		];

		// Traverse over all matches and create the corresponding tokens.
		return array_map(function ($match) use ($types) {
			foreach ($types as $type) {
				if (!empty($match[$type][0])) {
					return $this->createToken($type, $match[$type][0], $match[$type][1], $match);
				}
			}

			// There was a match outside of one of the token types.
			throw new \LogicException();
		}, $matches);
	}

	/**
	 * Reorganizes a list of tokens into reverse polish (postfix) notation.
	 *
	 * Uses an implementation of the Shunting-yard algorithm.
	 *
	 * http://en.wikipedia.org/wiki/Shunting-yard_algorithm
	 *
	 * @param \Drupal\amazee_assessment\Token\TokenInterface[] $tokens
	 *   The tokens to be reorganized into reverse polish (postfix) notation.
	 *
	 * @return \Drupal\amazee_assessment\Token\TokenInterface[]
	 *   The given tokens in reverse polish (postfix) notation.
	 *
	 * @throws \Drupal\amazee_assessment\Exception\IncorrectParenthesisException
	 * @throws \Drupal\amazee_assessment\Exception\IncorrectExpressionException
	 */
	public function postfix($tokens) {
		$output = [];
		$stack = [];

		foreach ($tokens as $token) {
			if ($token instanceof NumberToken) {
				$output[] = $token;
			}
			elseif ($token instanceof ParenthesisOpenToken) {
				array_push($stack, $token);
			}
			elseif ($token instanceof CommaToken) {
				while (($current = array_pop($stack)) && (!$current instanceof ParenthesisOpenToken)) {
					$output[] = $current;

					if (empty($stack)) {
						throw new IncorrectExpressionException();
					}
				}
			}
			elseif ($token instanceof ParenthesisCloseToken) {
				while (($current = array_pop($stack)) && !($current instanceof ParenthesisOpenToken)) {
					$output[] = $current;
				}


			}
			elseif ($token instanceof OperatorTokenInterface) {
				while (!empty($stack)) {
					$last = end($stack);
					if (!($last instanceof OperatorTokenInterface)) {
						break;
					}

					$associativity = $token->getAssociativity();
					$precedence = $token->getPrecedence();
					$last_precedence = $last->getPrecedence();
					if (!(
						($associativity === OperatorTokenInterface::ASSOCIATIVITY_LEFT && $precedence <= $last_precedence) ||
						($associativity === OperatorTokenInterface::ASSOCIATIVITY_RIGHT && $precedence < $last_precedence)
					)
					) {
						break;
					}

					$output[] = array_pop($stack);
				}

				array_push($stack, $token);
			}
		}

		while (!empty($stack)) {
			$token = array_pop($stack);
			if ($token instanceof ParenthesisOpenToken || $token instanceof ParenthesisCloseToken) {
				throw new IncorrectParenthesisException();
			}

			$output[] = $token;
		}

		return $output;
	}

	/**
	 * Creates a token object of the given type.
	 *
	 * @param string $type
	 *   The type of the token.
	 * @param string $value
	 *   The matched string.
	 * @param int $offset
	 *   The offset of the matched string.
	 * @param $match
	 *   The full match as returned by preg_match_all().
	 *
	 * @return \Drupal\amazee_assessment\Token\TokenInterface
	 *   The created token object.
	 *
	 * @throws \Drupal\amazee_assessment\Exception\UnknownOperatorException
	 * @throws \Drupal\amazee_assessment\Exception\UnknownTokenException
	 */
	protected function createToken($type, $value, $offset, $match) {
		switch ($type) {
			case 'number':
				return new NumberToken($offset, $value);

			case 'open':
				return new ParenthesisOpenToken($offset, $value);

			case 'close':
				return new ParenthesisCloseToken($offset, $value);

			case 'comma':
				return new CommaToken($offset, $value);

			case 'operator':
				foreach ($this->operators as $id => $operator) {
					if (!empty($match["op_$id"][0])) {
						return new $operator[1]($offset, $value);
					}
				}
				throw new UnknownOperatorException($offset, $value);
		}

		throw new UnknownTokenException($offset, $value);
	}

	/**
	 * Builds a concatenated regular expression for all available operators.
	 *
	 * @return string
	 *   The regular expression for matching all available operators.
	 */
	protected function getOperatorRegex() {
		$operators = [];
		foreach ($this->operators as $id => $operator) {
			$operators[] = "(?P<op_$id>{$operator[0]})";
		}
		return implode('|', $operators);
	}

	/**
	 * Compiles the regular expressions of all token types.
	 *
	 * @return string
	 *   The compiled regular expression.
	 */
	protected function getCompiledTokenRegex() {
		if (isset($this->compiledRegex)) {
			return $this->compiledRegex;
		}

		$regex = [
			sprintf('(?P<number>%s)', '\-?\d+\.?\d*(E-?\d+)?'),
			sprintf('(?P<open>%s)', '\('),
			sprintf('(?P<close>%s)', '\)'),
			sprintf('(?P<comma>%s)', '\,'),
			sprintf('(?P<operator>%s)', $this->getOperatorRegex()),
		];

		$regex = implode('|', $regex);
		return $this->compiledRegex = "/$regex/i";
	}

}
