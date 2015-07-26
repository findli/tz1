<?php
/**
 * Created by PhpStorm.
 * User: ya
 * Date: 1/28/14
 * Time: 4:08 PM
 */

namespace framework;

/**
 * Class Controller
 * @package framework
 */
class Controller extends Base
{
	function __construct()
	{
	}

	function applyFilters( $action )
	{
		$action  = strtolower( substr_replace( $action, '', 0, strlen( 'action' ) ) );
		$filters = $this->filters();
		foreach ( $filters as $k1 => $v1 ) {
			if ( strtolower( $k1 ) === $action ) {
//				echo '<br>';
//				echo Request::getType() . ' !== ' . strtoupper($v1);
//				echo '<br>';
				$this->ensure( Request::getType() === strtoupper( $v1 ), 'Http404', NULL );
			}
		}
	}

	function filters()
	{
		return [ 'index' => 'get' ];
	}

	/**
	 * @TODO add parameters to actions funcs
	 * @param Request $request
	 */
	function execute( Request $request )
	{
		$action = $request->getAction();
		$action = 'action' . ucfirst( $action );
		$this->ensure( method_exists( $this, $action ), 'Http404', '404: Action not found!' );
		$this->applyFilters( $action );
		$method        = new \ReflectionMethod( $this, $action );
		$requestParams = $method->getParameters();
        $funcParams    = [ ];
        foreach ( $requestParams as $k1 => $v1 ) {
            if ( Request::getParam( $v1->name ) ) {
                $funcParams[ $v1->name ] = Request::getParam( $v1->name );
            }
        }
		call_user_func_array( [ $this, $action ], $funcParams );
	}

	protected function render( $view, $params = [ ] )
	{
		$filename = Autoloader::resolvePath( '\theme\\' . 'default/view/' . $view );
		$this->ensure( is_file( $filename ), 'FileNotFound', 'wrong view: ' . $view );
		extract( $params );
		include_once $filename;
	}

	public function getFormUri()
	{
		$uri = '/' . Request::getController() . '/' . Request::getAction();

		return $uri;
	}

}
