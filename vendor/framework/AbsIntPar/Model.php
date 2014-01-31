<?php
/**
 * Created by PhpStorm.
 * User: ya
 * Date: 1/31/14
 * Time: 1:11 AM
 */

namespace framework\AbsIntPar;


use exceptions\DbError;
use framework\ApplicationRegistry;
use framework\Base;

class Model extends Base
{
	public $params = [ ];

	static $instance;

	private function __construct()
	{
	}

	public static function instance()
	{
		if ( !isset( self::$instance ) ) {
			$static = new static();
			$static->init();
			self::$instance = $static;
		}

		return self::$instance;
	}

	public function init()
	{
		$this->setConnection();
		$this->setCollection();
	}

	public function load( $params )
	{
		if ( is_array( $params ) ) {
			foreach ( $params as $k1 => $v1 ) {
				$this->params[ $k1 ] = $v1;
			}
		}
	}

	function set( $k1, $v1 )
	{
		$this->params[ $k1 ] = $v1;
	}

	function get( $k1 )
	{
		return ( isset( $this->params[ $k1 ] ) ? $this->params[ $k1 ] : NULL );
	}

	function validate()
	{
		//@TODO validate
	}

	function getError( $name )
	{
		return 1;
	}
}

