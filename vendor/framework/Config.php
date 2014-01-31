<?php
/**
 * Created by PhpStorm.
 * User: ya
 * Date: 1/28/14
 * Time: 3:05 PM
 */

namespace framework;

use exceptions\FileNotFound;
use framework\AbsIntPar\Registry;

class Config extends Registry
{
	public static $params = [ ];

	/**
	 * load configuration directives from config file.
	 * @param null $filename
	 * @throws \exceptions\FileNotFound
	 */
	function load( $filename = NULL )
	{
		if ( is_file( $filename ) ) {

		} else {
			throw new FileNotFound( 'config file not exist!' );
		}
	}

}