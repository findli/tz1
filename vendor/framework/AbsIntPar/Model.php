<?php
/**
 * Created by PhpStorm.
 * User: ya
 * Date: 1/31/14
 * Time: 1:11 AM
 */

namespace framework\AbsIntPar;


use exceptions\DbError;
use framework\ApplicationHelper;
use framework\ApplicationRegistry;
use framework\Autoloader;
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
				$this->params[ $k1 ] = htmlentities( $v1 );
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

	function getLabel( $k1 )
	{
		if ( isset( $this->labels()[ $k1 ] ) ) {
			return $this->labels()[ $k1 ];
		} else {
			//@TODO $this->allowedByRules()
			return ucfirst( $k1 );
		}
	}

	function validate()
	{
		//@TODO validate
		echo '<pre>';
		var_dump( $this->params );
		$paramsWithRules = $this->getParamsWithRules();
		print_r( $paramsWithRules );
		$return = [ ];
		foreach ( $paramsWithRules as $k1 => $v1 ) {
			foreach ( $v1 as $k2 => $v2 ) {
				$validatorName = ucfirst( strtolower( $k1 ) );

				$validators = ApplicationHelper::get( 'validators' );
				if ( in_array( $validatorName, $validators ) ) {
					$validatorClass = '\framework\Db\filters\\' . $validatorName;
					$resolvePath    = Autoloader::resolvePath( $validatorClass );
//					var_dump($resolvePath);
//					die(var_dump(is_file($resolvePath)));
					$this->ensure( is_file( $resolvePath ), 'Http404', '404: Controller not found!' );
					include_once $resolvePath;
					$this->ensure( class_exists( $validatorClass ), 'Http404', '404: Controller not found!' );
					if ( $this->getIsRequiered( $v2 ) && !isset( $this->params[ $v2 ] ) ) {
						$allowEmpty = FALSE;
					} else {
						$allowEmpty = TRUE;
					}
					$var       = ( isset( $this->params[ $v2 ] ) ) ? $this->params[ $v2 ] : NULL;
					$return[ ] = ( new $validatorClass )->check( $var, $allowEmpty );
				} else {
					// search function
					$return[ ] = $this->$validatorName( $this->params[ $v2 ] );
				}
			}
		}

		if ( in_array( FALSE, $return ) ) {
			return FALSE;
		} else {
			return TRUE;
		}

	}

	function getIsRequiered( $name )
	{
		$paramsWithRules = $this->getParamsWithRules();
		if ( isset( $paramsWithRules[ 'required' ] ) ) {
			if ( in_array( $name, $paramsWithRules[ 'required' ] ) ) {
				return TRUE;
			}
		}

		return FALSE;
	}

	function getParamsWithRules()
	{
		$rules = $this->rules();
		foreach ( $rules as $k1 => $v1 ) {
			if ( is_array( $v1[ 0 ] ) ) {
				foreach ( $v1[ 0 ] as $k2 => $v2 ) {
					$paramsWithRules[ $v1[ 1 ] ][ ] = $v2;
				}
			} else {
				$paramsWithRules[ $v1[ 1 ] ][ ] = $v1[ 0 ];
			}
		}

		return $paramsWithRules;
	}

	function getError( $name )
	{
		return 1;
	}
}

