<?php
namespace Drupal\amazee_assessment_example\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Created by PhpStorm.
 * User: ldcontreras
 * Date: 1/10/18
 * Time: 7:05
 */
class AmazeeExampleController extends ControllerBase {

	public function showResult ($result) {
		return [ '#theme' => 'show_result_expression',
			'#result'=>$result,
		];
	}

}