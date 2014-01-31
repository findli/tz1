<?php
/**
 * Created by PhpStorm.
 * User: ya
 * Date: 1/28/14
 * Time: 3:47 PM
 */

namespace framework;

use \framework\AbsIntPar\Registry;

/**
 * Class Session
 *
 * session storage
 *
 * @package framework
 */
class Session extends Registry
{
	public static function set( $k1, $v1 )
	{
		$_SESSION[ __CLASS__ ][ $k1 ] = $v1;

		return $_SESSION[ __CLASS__ ][ $k1 ];
	}

	public static function get( $k1 )
	{
		return $_SESSION[ __CLASS__ ][ $k1 ];
	}
}