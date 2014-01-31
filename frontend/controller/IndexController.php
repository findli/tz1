<?php
/**
 * Created by PhpStorm.
 * User: ya
 * Date: 1/28/14
 * Time: 12:52 PM
 */

namespace controller;

use framework\Controller;
use framework\Request;
use model\Categories;

class IndexController extends Controller
{
	function actionIndex()
	{

		$this->render( 'view/index', [
			'test1' => Request::get( 'test1' ),
			'test2' => Request::get( 'test2' ),
		] );
	}

	function actionForm1()
	{
		if ( Request::getType() === 'post' ) {
			$model = Categories();
			$model->load();
			if ( $model->validate() ) {
				$model->save();
			}
		} else {
			$model = Categories::instance()
			                   ->findOne( [ 'name' => 'Home' ] );
		}
		$this->render( 'view/form1', [
			'model' => $model,
		] );

	}
}