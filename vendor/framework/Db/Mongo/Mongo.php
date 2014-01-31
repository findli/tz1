<?php
/**
 * Created by PhpStorm.
 * User: ya
 * Date: 1/31/14
 * Time: 7:12 PM
 */
namespace framework\Db\Mongo;

use framework\AbsIntPar;

class Mongo extends AMongo
{

	public $attributes;
	public $_id = NULL;


	public function load( $data, $formName = NULL )
	{
		$collectionName = static::collectionName();
		if ( empty( $data[ ucfirst( $collectionName ) ] ) ) {
			$this->attributes = $data;
		} else {
			$this->attributes = $data[ ucfirst( $collectionName ) ];
		}
	}

	public function save( $runValidation = TRUE, $attributes = NULL )
	{
		if ( is_null( $attributes ) ) {
			return $this->insert( $runValidation, $this->attributes );
		} else {
			return $this->insert( $runValidation, $attributes );
		}
	}

	public function insert( $runValidation = TRUE, $attributes = NULL )
	{
		if ( $attributes === NULL ) {
			$attributes = $this->attributes;
		}
		try {
			if ( $return = (bool) $this->_collection->insert( $attributes ) ) {
				$this->_id = $attributes[ '_id' ];
			} else {
				$return = FALSE;
			}
		} catch ( \Exception $e ) {
			echo '<pre>';
			var_dump( $e->getMessage() );
			echo '</pre>';
			exit();
		}

		return $return;
	}

	public function findById( $id )
	{
		if ( get_class( $id ) && $id instanceof \MongoId ) {
			$id = new \MongoId( $id );
		}

		$this->params = $this->_collection->findOne( [ '_id' => $id ] );
		return $this;
	}

	public function find( $query, $fields = NULL )
	{
		$this->ensure( is_array( $query ), 'DbError', NULL );

		$this->params = $this->_collection->find( $query, $fields );
		return $this;
	}

	public function findOne( $query, $fields = NULL )
	{
		$this->ensure( is_array( $query ), 'DbError', NULL );
		if ( isset( $fields ) && is_array( $fields ) ) {
			$this->params = $this->_collection->findOne( $query, $fields );
		} else {
			$this->params = $this->_collection->findOne( $query );
		}
		return $this;
	}

	public function update( array $criteria, array $new_object, array $options = array() )
	{
		return $this->_collection->update( $criteria, $new_object, $options = array() );
	}

	public function findAndModify( array $query, array $update, array $fields, array $options )
	{
		return $this->_collection->findAndModify( $query, $update, $fields, $options );
	}

}