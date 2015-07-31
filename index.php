<?
require_once( 'lib/tree.php' );
/**
 * Created by PhpStorm.
 * User: ya
 * Date: 1/28/14
 * Time: 12:48 PM
 */

require( 'vendor/framework/FrontController.php' );
$config = require_once( 'config.php' );
/*
 * initialize app
 */
//echo '<pre>';
//print_r($_SERVER);
//die;
$FrontController = new framework\FrontController();
$FrontController->run( $config );
