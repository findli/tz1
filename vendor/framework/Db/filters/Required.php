<?php
/**
 * Created by PhpStorm.
 * User: ya
 * Date: 2/5/14
 * Time: 2:43 PM
 */

namespace framework\Db\filters;


class Required extends AFilter
{
	function check( $val, $allowEmpty )
	{
		$checkEmpty = $this->checkEmpty( $val, $allowEmpty );
		if ( $checkEmpty !== NULL ) {
			return $checkEmpty;
		}
		if ( isset( $val ) ) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
} 