<?php
/**
 * Created by PhpStorm.
 * User: ya
 * Date: 1/28/14
 * Time: 12:52 PM
 */

namespace controller;

use framework\Base;
use framework\Controller;
use framework\Request;
use model\Categories;

class IndexController extends Controller
{
	function actionIndex( $test1 )
	{

		$this->render( 'index/index', [
			'test1' => $test1,
		] );
	}

	function actionForm1()
	{
		echo '<pre>';
		if ( Request::getType() === 'POST' ) {
			$model = Categories::instance();
			$param = Request::getParam( Base::getClass( get_class( $model ) ) );
			$model->load( $param );
			if ( $model->validate() ) {
				echo '<br>';
				die( 'validated' );
				$model->save();
			} else {
				echo '<br>';
				die( 'not validated!' );
			}
		} else {
			$model = Categories::instance()
			                   ->findOne( [ 'name' => 'Home' ] );
			echo '<br>';
//			die( 'not post' );
		}
		$this->render( 'index/form1', [
			'model' => $model,
		] );

	}
}