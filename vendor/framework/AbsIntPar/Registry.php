<?php

/**
 * Created by PhpStorm.
 * User: ya
 * Date: 1/28/14
 * Time: 1:59 PM
 */
namespace framework\AbsIntPar;

use framework\Base;

/**
 * Class Registry
 * Pattern: Registry
 *
 * @package framework
 */
class Registry extends Base
{
	private static $instance;

	final function __construct()
	{
	}

	final static function instance()
	{
		if ( !isset( self::$instance ) ) {
			self::$instance = new static();
		}

		return self::$instance;
	}

}