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
class Core_Bootstrap extends Zend_Application_Module_Bootstrap
{
	public function _initLoadModule()
	{
		Zend_Controller_Front::getInstance()->registerPlugin(new Core_Plugin_Auth());	
	}
}

