<?php

namespace Drupal\amazee_assessment;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * A plugin manager for AmazeeAssessmentLexer Plugin.
 */
class AmazeeAssessmentLexerManager extends DefaultPluginManager {

	/**
	 * Constructs a MessageManager object.
	 *
	 * @param \Traversable $namespaces
	 *   An object that implements \Traversable which contains the root paths
	 *   keyed by the corresponding namespace to look for plugin implementations.
	 * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
	 *   Cache backend instance to use.
	 * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
	 *   The module handler to invoke the alter hook with.
	 */
	public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
		$this->alterInfo('amazee_assessment_validators_info');
		$this->setCacheBackend($cache_backend, 'amazee_assessment_validators');

		parent::__construct(
			'Plugin/AmazeeAssessmentLexer',
			$namespaces,
			$module_handler,
			'Drupal\amazee_assessment\AmazeeAssessmentLexerInterface',
			'Drupal\amazee_assessment\Annotation\AmazeeAssessmentLexer'
		);
	}


	/**
	 * Execute calculate.
	 *
	 * @param string $value
	 *   Form Value.
	 * @return int $result.
	 */
	public function calculate($value) {

		$result = (new Calculator())->calculate($value);

		return $result;

	}


}
