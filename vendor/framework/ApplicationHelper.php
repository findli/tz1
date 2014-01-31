<?php
/**
 * Created by PhpStorm.
 * User: ya
 * Date: 1/30/14
 * Time: 1:50 PM
 */

namespace framework;


use framework\AbsIntPar\Registry;

/*
 * save session in mongodb for example.(why????)
 */

class ApplicationHelper extends Registry
{
	private static $params = [ ];

	function init( $params = NULL )
	{
		if ( !is_null( $params ) && is_array( $params ) ) {
			self::$params = $params;
		}
	}

	static function set( $k1, $v1 )
	{
		self::$params[ $k1 ] = $v1;
	}

	static function get( $k1 )
	{
		return self::$params[ $k1 ];
	}

} 