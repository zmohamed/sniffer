<?php
/**
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 * 
 * @category   Application
 * @package    Application_Main
 * @desc 	   Application main bootstrap file
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    Release: 1.0 (2011-10-18)
 */
/**
 * @category   Application
 * @package    Application_Main
 * @desc       Application main bootstrap file
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    Release: 1.0 (2011-10-18)
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initDefaultTranslation()
	{
		if(!$this->getResource('locale')) {
			$this->bootstrap('locale');
		}
		if(!$this->getResource('translate')) {
			$this->bootstrap('translate');
		}
		
		$language = $this->getResource('locale')->getLanguage();
		$mainConfig = $this->getOptions();
		$defaultLocale = $mainConfig['resources']['translate']['default'];
		$translate = $this->getResource('translate');
		if( !$translate->isAvailable($language)) {
			$translate->setLocale($defaultLocale);
		}
		
		// Adding log features 
		if( 'development' == APPLICATION_ENV ) {
			$writer = new Zend_Log_Writer_Stream(APPLICATION_PATH . '/../var/log/untranslated.log');
			$logger = new Zend_Log($writer);
			$translate->setOptions(array( 'log' => $logger, 'logUntranslated' => true));
		}
	}
	/**
     * Implements database session handling
     * 
     * @return void
     */
	protected function _initSessionHandler()
	{
		$mainConfig = $this->getOptions();
		$gcMaxlifetime = $mainConfig['phpSettings']['session']['gc_maxlifetime'] ? 
						 $mainConfig['phpSettings']['session']['gc_maxlifetime'] :
						 get_cfg_var('session.gc_maxlifetime');

		if(!$this->getResource('multidb')) {
			$this->bootstrap('multidb');
		}
		$dbAdapter = $this->getResource('multidb')->getDb('main');
		
		$saveHandler = new Ip_Session_SaveHandler_Db($dbAdapter, $gcMaxlifetime);
		Zend_Session::setSaveHandler($saveHandler);
	}
	
    /**
     * Pushes base css files (reset & fonts) into headLink stack
     * 
     * @return void
     */
    protected function _initLoadBaseCss()
    {
        if (!$this->getResource('view')){
            $this->bootstrap('view');
        }
        $this->getResource('view')->headLink()->appendStylesheet('/css/reset.css', 'all');
        $this->getResource('view')->headLink()->appendStylesheet('/css/fonts.css', 'all');
        $this->getResource('view')->headLink()->appendStylesheet('/css/base.css', 'all');
    }
    
/**
     * Adds custom rules into router
     * 
     * @return void
     */
    protected function _initRouter()
    {
        $router = Zend_Controller_Front::getInstance()->getRouter();
        if (!$this->getResource('cacheManager')) {
            $this->bootstrap('cacheManager');
        }
        $cache = $this->getResource('cacheManager')->getCache('content');
        // Adds routes defined in routes.ini
        $cacheId = 'coreRouterConfig';
        if (!$routerConfig = $cache->load($cacheId)) {
             $routerConfig = new Zend_Config_Ini(APPLICATION_PATH . DIRECTORY_SEPARATOR . 
                                                'Core' . DIRECTORY_SEPARATOR . 
             									'configs' . DIRECTORY_SEPARATOR . 
                                                'routes.ini', APPLICATION_ENV);
            $cache->save($routerConfig);
        }
        $router->addConfig($routerConfig, 'routes');
    }
    /**
     * Builds core navigation object
     * 
     * @return void
     */
    protected function _initNavigation()
    {
        if (!$this->getResource('cacheManager')) {
            $this->bootstrap('cacheManager');
        }
        $cache = $this->getResource('cacheManager')->getCache('content');
        $cacheId = 'navigation';
        if (!($navigation = $cache->load($cacheId))) {
            // Adds navigation for breadcrumbs
            $navigation = array();
            $navConfig = new Zend_Config_Xml(APPLICATION_PATH . DIRECTORY_SEPARATOR . 
            								 'Core' . DIRECTORY_SEPARATOR . 
                                             'configs' . DIRECTORY_SEPARATOR . 
                                             'navigation.xml', 'core');
            $cache->save($navigation);
        }
        $navigation = new Zend_Navigation($navConfig);
        Zend_Registry::set('navigation', $navigation);
    }
}

