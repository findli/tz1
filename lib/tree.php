<?php

/**
 * Created by PhpStorm.
 * User: Ya
 * Date: 31.07.2015
 * Time: 5:27
 */
class Tree
{
	function __construct( $db, $id, $children, $glub, $caption )
	{
		$this->db           = $db;
		$this->id           = $id;
		$this->caption      = $caption;
		$this->pt_children  = $children;
		$this->pt_childlist = array();
		$this->pt_glub      = $glub;
		if ( $children ) {
			$sql = "SELECT * FROM pages WHERE parent=?";
			$res = $this->db->prepare( $sql );
			$val = array( (int) $id );
			$res->execute( $val );
			$r = $res->fetchAll( PDO::FETCH_ASSOC );
			$j = 0;
			foreach ( $r as $row ) {
				$val_ = array( $row[ "pid" ] );
				$res->execute( $val_ );
				if ( count( $res->fetchAll( PDO::FETCH_ASSOC ) ) > 0 ) {
					$children = TRUE;
				} else {
					$children = FALSE;
				}
				$this->pt_childlist[ $j ] = new Tree( $db, $row[ "pid" ], $children, $this->pt_glub + 1, $row[ "title" ] );
				$j++;
			}
		}
	}

	function display( $responce )
	{
		if ( is_null( $responce ) ) {
			$responce = new stdClass();
		}
		if ( $this->pt_glub != 0 ) // это не корневой узел
		{
			$x = new stdClass();
			if ( $this->pt_children ) // имеет потомков?
			{
				@$x->text = $this->id . ' ' . $this->caption;
				@$x->id = $this->id;
				$x->children = array();
				array_push( $responce->children, $x ); // добавляем их в массив
				$result = $x;
			} else {
				@$x->text = $this->id . ' ' . $this->caption;
				@$x->id = $this->id;
				$x->children = array();
				array_push( $responce->children, $x );
				$result = $responce;
			}
		} else  // это корневой узел
		{
			@$responce->text = $this->id . ' ' . $this->caption;
			@$responce->id = $this->id;
			$responce->children = array();
			$result             = $responce;
		}
		$num = sizeof( $this->pt_childlist );
		for ( $j = 0; $j < $num; $j++ )
			$this->pt_childlist[ $j ]->display( $result ); // проходим в цикле весь массив
		return $responce;
	}

}

