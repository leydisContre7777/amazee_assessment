<?php

/**
 * @file
 * Contains \Drupal\amazee_assessment\Exception\IncorrectExpressionException.
 */

namespace Drupal\amazee_assessment\Exception;


class IncorrectExpressionException extends AmazeeAssessmentException {
	
	function __construct($message, $code, \Exception $previous) {
		parent::__construct($message, $code, $previous);
	}

}
