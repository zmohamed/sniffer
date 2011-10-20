<?php

/**
 * Application wrapper
 * 
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
 * @category  Application
 * @desc      Application main wrapper. Hangdles any request thanks to rewrite rule
 * @license   http://framework.zend.com/license/new-bsd     New BSD License
 * @version   Release: 1.0 (Stable 2011-10-18)
 */

/** 
 * Registers error and exception handlers 
 */
set_error_handler(array(
    'StartupTools', 'customErrorHandler'
));
set_exception_handler(array(
    'StartupTools', 'customExceptionHandler'
));

/**
 * Defines paths to application directories
 */
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));
defined('CONFIG_PATH') || define('CONFIG_PATH', realpath(dirname(__FILE__) . '/../application/Core/configs'));
defined('ROOT_PATH') || define('ROOT_PATH', realpath(dirname(dirname(__FILE__))));
/**
 * Defines application environment related constants
 */

defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
if ('production' !== APPLICATION_ENV) {
    ini_set('display_errors', 1);
}

/**
 * Ensures library/ is on include_path
 */
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path()
)));
/**
 * Startup checks
 */
StartupTools::configCheck();
StartupTools::dirPermCheck();
/** 
 * Zend_Application init
 */
require_once 'Zend/Application.php';
$application = new Zend_Application(APPLICATION_ENV, CONFIG_PATH . '/application.ini');
$application->bootstrap()->run();
/** 
 * Startup checks and error handlers 
 */
final class StartupTools
{
    /**
     * Checks wether config files exist before launching the app
     * 
     * @return void
     */
    public static function configCheck()
    {
        if (! file_exists(CONFIG_PATH . DIRECTORY_SEPARATOR . 'application.ini')) {
            echo ' <html><head></head><body><style><!--
                    body {
                        margin: 0px;
                    }
                    #content {
                        border: 1px solid #EFECBA;
                        width: 300px;
                        height: 150px;
                        background-color: #FBFAE7;
                        padding:20px;
                        top: 30%;
                        left: 50%;
                        position: absolute; 
                    }
                    #container  {
                        width: 100%;
                        height: 100%;
                        font: 11px tahoma;
                        position: absolute;
                        top: -75px;
                        left: -150px;
                    }
                    code{
                        color: red;
                    }
                    --></style>
                    <div id="container">
                    <div id="content"><b>Erreur lors de l\'initialisation de l\'
                    application...</b><br /><br /> Le fichier de configuration
                    principal est manquant ou endommag&eacute;.<br />';
            echo '</div>
                    </div></body></html>';
            exit(0);
        }
    }
    /**
     * Checks whether some dirs are writeable
     * 
     * @return void
     */
    public static function dirPermCheck()
    {
        $foldersToCheck = array(
            'var/', 
            'var/cache/', 
            'var/cache',  
            'var/log', 
        );
        $error = null;
        foreach ($foldersToCheck as $folder) {
            $writable = is_writable(ROOT_PATH . DIRECTORY_SEPARATOR . $folder);
            if (! $writable) {
                $error .= 'Le r&eacute;pertoire <strong>/' . $folder . '</strong> n\'
                est pas accessible en &eacute;criture.<br />';
            }
        }
        if (null !== $error) {
            echo ' <html><head></head><body><style><!--
                    body {
                        margin: 0px;
                    }
                    #content {
                        border: 1px solid #EFECBA;
                        width: 300px;
                        height: 150px;
                        background-color: #FBFAE7;
                        padding:20px;
                        top: 30%;
                        left: 50%;
                        position: absolute;
                    }
                    #container  {
                        width: 100%;
                        height: 100%;
                        font: 10px tahoma;
                        position: absolute;
                        top: -75px;
                        left: -150px;
                    }
                    code{
                        color: red;
                    }
                    --></style>
                    <div id="container">
                    <div id="content"><b>Erreur lors de l\'initialisation de l\'
                    application...</b><br /><br />Les droits sur certains 
                    r&eacute;pertoires sont inssufisants : <br /><br />';
            echo '<div style="color: red">' . $error . '</div>';
            echo '</div>
                  </div></body></html>';
            exit(0);
        }
    }
    /** 
     * Error handler
     * 
     * @param int    $errorCode    Numeric code returned by PHP
     * @param string $errorMessage Text error message returned by PHP
     * @return void
     */
    public static function customErrorHandler($errorCode, $errorMessage)
    {
        echo ' <html><head></head><body><style><!--
                    body {
                        margin: 0px;
                    }
                    #content {
                        border: 1px solid #EFECBA;
                        width: 300px;
                        height: 150px;
                        background-color: #FBFAE7;
                        padding:20px;
                        top: 30%;
                        left: 50%;
                        position: absolute;
                    }
                    #container  {
                        width: 100%;
                        height: 100%;
                        font: 11px tahoma;
                        position: absolute;
                        top: -75px;
                        left: -150px;
                    }
                    code{
                        color: red;
                    }
                    --></style>
                    <div id="container">
                    <div id="content"><b>Erreur PHP code ' . $errorCode . '</b>
                    <br /><br />
                    ' . $errorMessage . '';
        echo '</div>
                  </div></body></html>';
        exit(0);
    }
    /** 
     * Exception handler
     * @param int $exception The uncaught exception object returned by PHP 
     * @return void
     */
    public static function customExceptionHandler($exception)
    {
        echo ' <html><head></head><body><style><!--
                    body {
                        margin: 0px;
                    }
                    #content {
                        border: 1px solid #EFECBA;
                        width: 300px;
                        height: 150px;
                        background-color: #FBFAE7;
                        padding:20px;
                        top: 30%;
                        left: 50%;
                        position: absolute;
                    }
                    #container  {
                        width: 100%;
                        height: 100%;
                        font: 11px tahoma;
                        position: absolute;
                        top: -75px;
                        left: -150px;
                    }
                    code{
                        color: red;
                    }
                    --></style>
                    <div id="container">
                    <div id="content"><b>Exception générale (code ' . $exception->getCode() . ')</b>
                    <br /><br />
                    ' . $exception->getMessage() .'';
        echo '</div>
                  </div></body></html>';
        exit(0);
    }
}
