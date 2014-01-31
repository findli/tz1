<?php
/**
 * Created by PhpStorm.
 * User: ya
 * Date: 1/30/14
 * Time: 1:31 PM
 */

namespace framework;


class CommandResolver extends Base
{
	private static $base_cmd;
	private static $default_cmd;

	function __construct()
	{
		if ( !self::$base_cmd ) {
			self::$base_cmd    = new \ReflectionClass( '\framework\Controller' );
			self::$default_cmd = new DefaultCommand();
		}
	}

	function getCommand()
	{
		$controller  = ( new \framework\Request() )->getControllerClass();
		$resolvePath = Autoloader::resolvePath( $controller );
		$this->ensure( is_file( $resolvePath ), 'Http404', '404: Controller not found!' );
		include_once $resolvePath;
		$this->ensure( class_exists( $controller ), 'Http404', '404: Controller not found!' );
		$cmd_class = new \ReflectionClass( $controller );
		$this->ensure( $cmd_class->isSubclassOf( self::$base_cmd ), 'Http404', '404: Controller not found!' );

		return $cmd_class->newInstance();
	}

} 