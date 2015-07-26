<?php
/**
 * Created by PhpStorm.
 * User: ya
 * Date: 1/28/14
 * Time: 3:05 PM
 */

namespace framework;

use framework\AbsIntPar\Registry;

/**
 * Class Request
 *
 * for provide access with filtering to GET and POST params
 *
 * @package framework
 */
class Request extends Registry
{

	public static function getGet( $key )
	{
		return ( isset( $_GET[ $key ] ) ) ? htmlentities( $_GET[ $key ] ) : NULL;
	}

	public static function getPost( $key )
	{
		return ( isset( $_POST[ $key ] ) ) ? htmlentities( $_POST[ $key ] ) : NULL;
	}

	public static function getParam( $key )
	{
		if ( isset( $_GET[ $key ] ) ) {
			return ( $_GET[ $key ] );
		} elseif ( isset( $_POST[ $key ] ) ) {
			return ( $_POST[ $key ] );
		}

		return NULL;
	}

	function getControllerClass()
	{
		$controller = $this->getController();

		return '\controller\\' . $controller . 'Controller';
	}

	public static function getController()
	{
		$tmp1 = explode( '/', explode( '?', $_SERVER[ 'REQUEST_URI' ] )[ 0 ] );

		return $tmp1[ 1 ];
	}

	public static function getAction()
	{
		$tmp1 = explode( '/', explode( '?', $_SERVER[ 'REQUEST_URI' ] )[ 0 ] );

		return $tmp1[ 2 ];
	}

	static function getType()
	{
		return $_SERVER[ 'REQUEST_METHOD' ];
	}

	public static function getParams()
	{
		if ( self::getType() === 'GET' ) {
			return $_GET;
		} else {

		}
	}
}