<?php

namespace Drupal\amazee_assessment\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Amazee Assessment Lexer annotation.
 *
 * @Annotation
 */
class AmazeeAssessmentLexer extends Plugin {

	/**
	 * The plugin ID.
	 *
	 * @var string
	 */
	public $id;

	/**
	 * The human-readable name of the AmazeeAssessmentLexer.
	 *
	 * @ingroup plugin_translatable
	 *
	 * @var \Drupal\Core\Annotation\Translation
	 */
	public $label;

	/**
	 * A short description of the AmazeeAssessmentLexer.
	 *
	 * @ingroup plugin_translatable
	 *
	 * @var \Drupal\Core\Annotation\Translation
	 */
	public $description;

}
