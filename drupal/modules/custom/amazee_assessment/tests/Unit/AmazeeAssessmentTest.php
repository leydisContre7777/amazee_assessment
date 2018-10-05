<?php

/**
 * @file
 * Contains \Drupal\Tests\amazee_assessment\Unit\AmazeeAssessmentTest.
 */

namespace Drupal\Tests\amazee_assessment\Unit;

use Drupal\amazee_assessment\Lexer;
use Drupal\amazee_assessment\CommaToken;
use Drupal\amazee_assessment\Token\DivisionToken;
use Drupal\amazee_assessment\Token\MinusToken;
use Drupal\amazee_assessment\Token\MultiplyToken;
use Drupal\amazee_assessment\Token\NumberToken;
use Drupal\amazee_assessment\Token\ParenthesisCloseToken;
use Drupal\amazee_assessment\Token\ParenthesisOpenToken;
use Drupal\amazee_assessment\Token\PlusToken;
use Drupal\Tests\UnitTestCase;


/**
 * @coversDefaultClass \Drupal\amazee_assessment\Lexer
 * @group amazee_assessment
 */
class AmazeeAssessmentTest extends UnitTestCase {

	/**
	 * The lexer.
	 *
	 * @var \Drupal\amazee_assessment\Lexer.
	 */
	protected $lexer;

	/**
	 * {@inheritdoc}
	 */
	public function setUp() {
		parent::setUp();

		$this->lexer = new Lexer();
		$this->lexer
			->addOperator('plus', '\+', 'Drupal\amazee_assessment\Token\PlusToken')
			->addOperator('minus', '\-', 'Drupal\amazee_assessment\Token\MinusToken')
			->addOperator('multiply', '\*', 'Drupal\amazee_assessment\Token\MultiplyToken')
			->addOperator('division', '\/', 'Drupal\amazee_assessment\Token\DivisionToken')
			->addOperator('modulus', '\%', 'Drupal\amazee_assessment\Token\ModulusToken');

	}

	/**
	 * Tests that mathematical expressions are properly tokenized.
	 *
	 * @param string $expression
	 *   A mathematical expression.
	 * @param \Drupal\amazee_assessment\Token\TokenInterface[] $tokens
	 *   The list of matched tokens.
	 *
	 * @covers ::tokenize
	 * @dataProvider tokenizeProvider
	 */
	public function testTokenize($expression, $tokens) {
		$this->assertArrayEquals($tokens, $this->lexer->tokenize($expression));
	}


	/**
	 * Data provider for the testTokenize() test case.
	 */
	public function tokenizeProvider() {
		return [
			[
				'3 + 2',
				[
					new NumberToken(0, 3),
					new PlusToken(2, '+'),
					new NumberToken(4, 2),
				]
			],
			[
				'7/6',
				[
					new NumberToken(0, 7),
					new DivisionToken(1, '/'),
					new NumberToken(2, 6),
				]
			],


			[
				'5 + 4 * 2 / ( 7 - 5 ) + 3',
				[
					new NumberToken(0, 5),
					new PlusToken(2, '+'),
					new NumberToken(4, 4),
					new MultiplyToken(6, '*'),
					new NumberToken(8, 2),
					new DivisionToken(10, '/'),
					new ParenthesisOpenToken(12, '('),
					new NumberToken(14, 7),
					new MinusToken(16, '-'),
					new NumberToken(18, 5),
					new ParenthesisCloseToken(20, ')'),
					new PlusToken(22, '+'),
					new NumberToken(24, 3),
				]
			],
		];
	}


}