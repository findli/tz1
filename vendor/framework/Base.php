<?php
/**
 * Created by PhpStorm.
 * User: ya
 * Date: 1/30/14
 * Time: 2:44 PM
 */

namespace framework;

use exceptions\Http404;

class Base
{
	/**
	 * @TODO add logging
	 * @param $expr
	 * @param $exception
	 * @param $message
	 * @throws \exceptions\Http404
	 * @throws FileNotFound
	 */
	function ensure( $expr, $exception, $message )
	{
		if ( !$expr ) {
			switch ( $exception ) {
				case 'Http404':
					throw new Http404( $message );
					break;
				case 'FileNotFound':
					throw new FileNotFound( $message );
					break;
			}
		}
	}

} 