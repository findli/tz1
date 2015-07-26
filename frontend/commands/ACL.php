<?php
/**
 * Created by PhpStorm.
 * User: ya
 * Date: 2/4/14
 * Time: 3:15 PM
 */

namespace commands;


/**
 * Class ACL
 * response for use authentication
 * @package commands
 */
class ACL {
	function hasAccess($userId = null){
		if($userId === null){
			$userId = User::instance()->getId();
		}
	}

} 