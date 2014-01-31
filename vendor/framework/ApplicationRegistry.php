<?php
/**
 * Created by PhpStorm.
 * User: ya
 * Date: 1/31/14
 * Time: 11:15 AM
 */

namespace framework;


use framework\AbsIntPar\Registry;

class ApplicationRegistry extends Registry
{
	private static $params = [ ];

	static public function get( $k1 )
	{
		return ( isset( self::$params[ $k1 ] ) ) ? self::$params[ $k1 ] : NULL;
	}

	static public function set( $k1, $v1 )
	{
		self::$params[ $k1 ] = $v1;
	}
} 