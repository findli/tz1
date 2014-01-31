<?php
/**
 * Created by PhpStorm.
 * User: ya
 * Date: 1/28/14
 * Time: 12:48 PM
 */

require( 'vendor/framework/FrontController.php' );

/*
 * initialize app
 */
//echo '<pre>';
//print_r($_SERVER);
//die;
$params          = [ 'app_name' => 'task_manager' ];
$FrontController = new framework\FrontController( $params );
$FrontController->run();
