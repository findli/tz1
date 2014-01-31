<?php
/**
 * Created by PhpStorm.
 * User: ya
 * Date: 1/31/14
 * Time: 7:14 PM
 */

namespace framework\Db\Mongo;

use framework\AbsIntPar\Model;

abstract class AMongo extends Model
{

	private $_db = NULL;
	protected $_collection = NULL;

	public function setConnection()
	{
		$connectionString = 'mongodb://localhost:27017/fastauctionscom';
		try {
			$m         = new \MongoClient( $connectionString );
			$this->_db = $m->selectDB( 'fastauctionscom' );

		} catch ( \Exception $e ) {
			new DbError( $e->getMessage() );
		}
	}

	public function setCollection()
	{
		$collectionName    = static::collectionName();
		$this->_collection = $this->_db->selectCollection( $collectionName );
	}

	abstract public function findById( $id );

	abstract public function find( $query, $fields );

	abstract public function findOne( $query, $fields );

	abstract public function save( $runValidation, $attributes );

	abstract public function update( array $criteria, array $new_object, array $options = array() );
}
