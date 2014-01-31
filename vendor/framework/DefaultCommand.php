<?php
/**
 * Created by PhpStorm.
 * User: ya
 * Date: 1/30/14
 * Time: 2:23 PM
 */

namespace framework;

class DefaultCommand extends Controller
{
	public function actionError()
	{
		$this->ensure( TRUE, 'Http404', NULL );
	}
} 