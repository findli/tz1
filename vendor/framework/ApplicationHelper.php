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
	private static $config = [ ];

	function init( $config = NULL )
	{
		if ( !is_null( $config ) && is_array( $config ) ) {
			self::$config = $config;
		}
	}

	static function set( $k1, $v1 )
	{
		self::$config[ $k1 ] = $v1;
	}

	static function get( $k1 )
	{
		return self::$config[ $k1 ];
	}

} 