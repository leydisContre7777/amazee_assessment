<?php

namespace Drupal\amazee_assessment;

use Drupal\Core\Form\FormStateInterface;

/**
 * Amazee Assessment Lexer Plugin Interface.
 */
interface AmazeeAssessmentLexerInterface {

	/**
	 * Execute calculate.
	 *
	 * @param \Drupal\amazee_assessment\Calculator $value
	 *   Input expression.
	 * @param array $element
	 *   Form Element.
	 * @param \Drupal\Core\Form\FormStateInterface $form_state
	 *   Form State.
	 *
	 * @return bool
	 *   Check.
	 */
	public function calculate (Calculator $value, array $element, FormStateInterface $form_state);

}
