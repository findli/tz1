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

class ExampleController extends Controller
{
	function actionTree()
	{

		$this->render( 'example/tree', [
		] );
	}

}