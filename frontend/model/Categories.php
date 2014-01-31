<?php
/**
 * Created by PhpStorm.
 * User: ya
 * Date: 1/31/14
 * Time: 11:49 AM
 */

namespace model;

use framework\Db\Mongo\Mongo;

class Categories extends Mongo
{
	function collectionName()
	{
		return 'categories';
	}

	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
			// username and password are both required
			[ [ 'username', 'password' ], 'required' ],
			// password is validated by validatePassword()
			[ 'password', 'validatePassword' ],
			// rememberMe must be a boolean value
			[ 'rememberMe', 'boolean' ],
		];
	}

	public function labels()
	{
		return [
			'name'        => 'Name',
			'description' => 'Description',
		];
	}

	public function validatePassword( $value )
	{
		return TRUE;
	}
} 