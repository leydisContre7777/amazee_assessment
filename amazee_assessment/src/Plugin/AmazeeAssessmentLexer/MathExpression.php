<?php

namespace Drupal\amazee_assessment\Plugin\AmazeeAssessmentLexer;

use Drupal\Core\Form\FormStateInterface;
use Drupal\amazee_assessment\AmazeeAssessmentLexerInterface;
use Drupal\amazee_assessment\Calculator;

/**
 * Calculate Input Expression Plugin.
 *
 * @AmazeeAssessmentLexer (
 *   id = "lexer_math_express",
 *   label = @Translation("Lexer Math Expression"),
 *   description = @Translation("Calculate a Mathematical Expression.")
 * )
 */
class MathExpression implements AmazeeAssessmentLexerInterface {

	/**
	 * {@inheritdoc}
	 */
	public function calculate (Calculator $calculator, array $element, FormStateInterface $form_state) {
		$value = $calculator->getValue();
		$calculator->calculate($value,  $variables = []);
	}

}
