<?php
/**
 * Created by PhpStorm.
 * User: ya
 * Date: 1/28/14
 * Time: 2:13 PM
 */

namespace framework;

require_once( 'Autoloader.php' );
require_once 'Base.php';

class FrontController extends Base
{

	public static function run()
	{

		$main = new FrontController();
		$main->init();
		$main->handleRequest();
	}

	function init()
	{
		Autoloader::instance()
		          ->registerAutoloader();
		ApplicationHelper::instance()
		                 ->init();
	}

	function handleRequest()
	{
		$request = new Request();
		$cmd     = ( new CommandResolver() )->getCommand( $request );
		$cmd->execute( $request );

	}
}
