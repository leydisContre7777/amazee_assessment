<?php

namespace Drupal\amazee_assessment_example\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements the SimpleForm form controller.
 *
 * This example demonstrates a simple form with a text input element to type. We
 * extend FormBase which is the simplest form base class used in Drupal.
 *
 * @see \Drupal\Core\Form\FormBase
 */
class SimpleForm extends FormBase {

	/**
	 * Build the simple form.
	 *
	 * A build form method constructs an array that defines how markup and
	 * other form elements are included in an HTML form.
	 *
	 * @param array $form
	 *   Default form array structure.
	 * @param Drupa\core\Form\FormStateInterface $form_state
	 *   Object containing current form state.
	 *
	 * @return array
	 *   The render array defining the elements of the form.
	 */
	public function buildForm(array $form, FormStateInterface $form_state) {


    // Text field to input the mathematical expression.
		$form['title'] = [
			'#type' => 'textfield',
			'#title' => $this->t('Enter your mathematical expression'),
			'#description' => $this->t('Mathematical expression.'),
			'#validators' => 'math_expression',
			'#required' => TRUE,
		];
		

		$form['actions'] = [
			'#type' => 'actions',
		];

		// Add a submit button that handles the submission of the form.
		$form['actions']['submit'] = [
			'#type' => 'submit',
			'#value' => $this->t('Submit'),
		];
		
		return $form;
	}

	/**
	 * Getter method for Form ID.
	 *
	 *
	 * @return string
	 *   The unique ID of the form defined by this class.
	 */
	public function getFormId() {
		return 'amazee_assessment_example_simple_form';
	}

	/**
	 * Implements a form submit handler.
	 *
	 * The submitForm method is the default method called for any submit elements.
	 *
	 * @param array $form
	 *   The render array of the currently built form.
	 * @param Drupal\Core\Form\FormStateInterface $form_state
	 *   Object describing the current state of the form.
	 */
	public function submitForm(array &$form, FormStateInterface $form_state) {
	
		$manager = \Drupal::service('plugin.manager.amazee_assessment_lexer');

		$values = $form_state->getValues();

		$expression = $values['title'];

		$result = $manager->calculate($expression);
		
		
		$url = \Drupal\Core\Url::fromRoute('amazee_assessment_example.manage')
			->setRouteParameters(array('result'=>$result));

		$form_state->setRedirectUrl($url);



	}

}
