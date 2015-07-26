<?php
/**
 * Created by PhpStorm.
 * User: ya
 * Date: 1/31/14
 * Time: 11:49 AM
 */

namespace model;

use framework\Db\Mongo\Mongo;

class Users extends Mongo
{
	function collectionName()
	{
		return 'users';
	}

	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
			// username and password are both required
			[ [ 'email', 'password' ], 'required' ],
			// password is validated by validatePassword()
			[ 'password', 'validatePassword' ],
			// rememberMe must be a boolean value
			[ 'rememberMe', 'boolean' ],
		];
	}

	public function labels()
	{
		return [
		];
	}

	public function validatePassword( $value )
	{
		return TRUE;
	}
} 