<?php
/**
 * Created by PhpStorm.
 * User: ya
 * Date: 2/5/14
 * Time: 2:44 PM
 */

namespace framework\Db\filters;

use framework\Base;

abstract class AFilter extends Base
{
	abstract public function check( $val, $allowEmpty );

	function checkEmpty( $val, $allowEmpty )
	{
		if ( empty( $val ) ) {
			if ( $allowEmpty ) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return NULL;
		}
	}
}