<?php
namespace ZendServerCustomAuthModule;

use Zend\Loader\StandardAutoloader;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface as AutoloaderProvider;

/**
 * 
 * @author gregory.chris@roguewave.com
 * 
 */
class Module implements AutoloaderProvider {
    
    /**
     * 
     * @return array 
     */
    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                StandardAutoloader::LOAD_NS => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            ),
        );
    }
    
    /**
     * 
     * @return array
     */
    public function getServiceConfig() {
        $moduleConfig = $this->getConfig();
        
        return array(
            'invokables' => array(
                // for simple cases, without DI
                //'ZendServerCustomAuthModule\Authentication\Adapter\Adapter' => 'ZendServerCustomAuthModule\Authentication\Adapter\Adapter',
            ),
            
            'factories' => array(
            
                // model's factory
                'ZendServerCustomAuthModule\Authentication\Model\File' => function($sm) use ($moduleConfig) {
                    $fileModel = new \ZendServerCustomAuthModule\Authentication\Model\File();
                    $fileModel->setDataFilePath($moduleConfig['users']['file']);
                    return $fileModel;
                },
                
                // adapter's factory
                'ZendServerCustomAuthModule\Authentication\Adapter\Adapter' => function($sm) {
                    $adapter = new \ZendServerCustomAuthModule\Authentication\Adapter\Adapter();
                    $adapter->setModel($sm->get('ZendServerCustomAuthModule\Authentication\Model\File'));
                    
                    return $adapter;
                }
            ),
        );
    }
    
    /**
     * 
     * @return array
     */
    public function getConfig() {
        return include __DIR__.'/config/module.config.php';
    }
    
}

