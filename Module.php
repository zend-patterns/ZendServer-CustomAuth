<?php
namespace CustomAuth;

use Zend\Loader\StandardAutoloader;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface as AutoloaderProvider;

/**
 * 
 * @author yonni.m@zend.com
 * 
 */
class Module implements AutoloaderProvider {

	public function getAutoloaderConfig() {
		return array(
			'Zend\Loader\StandardAutoloader' => array(
				StandardAutoloader::LOAD_NS => array(
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
				)
			),
		);
	}
}

