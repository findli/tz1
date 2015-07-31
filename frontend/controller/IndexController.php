<?php
/**
 * Created by PhpStorm.
 * User: ya
 * Date: 1/28/14
 * Time: 12:52 PM
 */

namespace controller;

use framework\Base;
use framework\Controller;
use framework\Request;
use model\Categories;

class IndexController extends Controller
{
	function actionIndex()
	{

		$this->render( 'index/index', [
		] );
	}

	function action1()
	{
		$str = '980923ûכגמאשרûגאד902ך3ûמג
[resolve_urls]f1;ddd
mmm[/resolve_urls]ûגא.‏בüדר
[banned_urls]f1;ddd;mmm[/banned_urls][own_domain]true[/own_domain]
[ban_file]f1;ddd;mmm[/ban_file]
[ban_mime]f1;ddd;mmm[/ban_mime]
[iconv_file:WINDOWS-1251=>UTF-8]f1;ddd;mmm[/iconv_file]
[iconv_file:KOI8-R=>UTF-8]f1;ddd;mmm[/iconv_file]
[iconv_mime:WINDOWS-1251=>UTF-8]f1;
ddd;
mmm
[/iconv_mime]sd908f90
[replace_file]inF===ourF;ddd===ppp;mmm===rrr[/replace_file]
[add_file:FILE]DATA[/add_file]
dsiu90843
[post:URL_LOCATION]DATA

[/post]
,dfkdjfkdjf';

		$res = preg_match_all( "~\[([a-zA-Z_]*)[:]{0,1}([0-9a-zA-Z\>_=;-]*)]([\s\na-zA-Z=;_0-9]*)\[\/([a-zA-Z_=;0-9]*)]{1,1}~m", $str, $matches );

		$arrBBNameValue       = [ ];
		$arrBBNameDescription = [ ];
		for ( $i = 0; $i < $res; $i++ ) {
			if ( $matches[ 1 ][ $i ] === $matches[ 4 ][ $i ] ) {
				$arrBBNameValue[ $matches[ 1 ][ $i ] ]       = $matches[ 3 ][ $i ];
				$arrBBNameDescription[ $matches[ 1 ][ $i ] ] = $matches[ 2 ][ $i ];
			}
		}
		$this->render( 'index/1', array( 'arrBBNameValue' => $arrBBNameValue, 'arrBBNameDescription' => $arrBBNameDescription ) );
	}

	function action2()
	{
		$str = <<< EOD
dfkjsfkj   dskljsdlfm sdfkjdsf sfsd get
asdkljasd,laosid post:
url: oiwerweroi;get:787wesdjhfsdfnxczp
EOD;
		$res = preg_match_all( "~((?:get:)|(?:post:)|(?:url:))([\n]*[$]*[\Z]*[\s]*[\>]*[\s\n\v:;a-z,0-9]*?)(?:(?=(?:get:)|(?:post:)|(?:url:)|(?:$)))~m", $str, $matches, PREG_SET_ORDER );
// https://regex101.com/r/cU7jT0/2#pcre

		$output = [ ];
		foreach ( $matches as $k => $v ) {
			$output[ $v[ 1 ] ] = $v[ 2 ];
		}
		$this->render( 'index/2', [ 'output' => $output, 'str' => $str ] );
	}

	function action3()
	{
		$this->render( 'index/3', [ ] );

	}

	function action3ajax()
	{
		$dsn = 'mysql:host=' . \framework\ApplicationHelper::get( 'DB_HOST' ) . ';dbname=' . \framework\ApplicationHelper::get( 'DB_NAME' );
		$dbh = new \PDO( $dsn, \framework\ApplicationHelper::get( 'DB_USER' ), \framework\ApplicationHelper::get( 'DB_PASSWORD' ) );
		$dbh->setAttribute( \PDO::ATTR_EMULATE_PREPARES, TRUE );
		$sql = "SELECT * FROM pages WHERE parent IS NULL";
		$res = $dbh->prepare( $sql );
		$res->execute();
		$r = $res->fetchAll( \PDO::FETCH_ASSOC );
		$res->closeCursor();

		$i      = 0;
		$result = [ ];
		foreach ( $r as $row ) {
			$tree         = new \Tree( $dbh, $row[ 'pid' ], TRUE, 0, $row[ 'title' ] );
			$result[ $i ] = $tree->display( NULL );
			$i++;
		}

		echo json_encode( $result );
	}

	function action4()
	{
		$dsn = 'mysql:host=' . \framework\ApplicationHelper::get( 'DB_HOST' ) . ';dbname=' . \framework\ApplicationHelper::get( 'DB_NAME' );
		$dbh = new \PDO( $dsn, \framework\ApplicationHelper::get( 'DB_USER' ), \framework\ApplicationHelper::get( 'DB_PASSWORD' ) );
		$sql = 'select count(pid) as counter_pid, parent from pages where parent IN (SELECT pid from pages WHERE parent IS NULL) GROUP BY parent HAVING counter_pid > 3';
		$dbh->setAttribute( \PDO::ATTR_EMULATE_PREPARES, TRUE );
		$res = $dbh->prepare( $sql );
		$res->execute();
		$r = $res->fetchAll( \PDO::FETCH_ASSOC );
		$res->closeCursor();
		$this->render( 'index/4', [ 'result' => $r ] );
	}

	function action5()
	{
		$dsn = 'mysql:host=' . \framework\ApplicationHelper::get( 'DB_HOST' ) . ';dbname=' . \framework\ApplicationHelper::get( 'DB_NAME' );
		$dbh = new \PDO( $dsn, \framework\ApplicationHelper::get( 'DB_USER' ), \framework\ApplicationHelper::get( 'DB_PASSWORD' ) );
		$sql = 'select t1.pid from

(SELECT pages3.pid, pages3.parent from pages as pages1
LEFT JOIN pages as pages2
 ON pages1.parent=pages2.pid

left join pages as pages3
ON pages3.pid = pages1.pid


#left join pages as pages4

#ON pages4.parent != pages3.pid

WHERE pages1.pid != pages2.parent AND pages3.parent = pages2.pid #AND pages3.pid != pages4.parent
GROUP BY pages1.pid DESC
) as t1

left JOIN

(SELECT pages3.pid as parent, pages3.parent as pid from pages as pages1
LEFT JOIN pages as pages2
 ON pages1.parent=pages2.pid

left join pages as pages3
ON pages3.pid = pages1.pid


#left join pages as pages4

#ON pages4.parent != pages3.pid

WHERE pages1.pid != pages2.parent AND pages3.parent = pages2.pid# AND pages3.pid != pages4.parent
GROUP BY pages1.pid DESC
) as t2

ON t1.pid=t2.pid

where t2.pid IS NULL
';
		$dbh->setAttribute( \PDO::ATTR_EMULATE_PREPARES, TRUE );
		$res = $dbh->prepare( $sql );
		$res->execute();
		$r = $res->fetchAll( \PDO::FETCH_ASSOC );
		$res->closeCursor();
		$this->render( 'index/5', [ 'result' => $r ] );
	}

	function action6()
	{
		$this->render( 'index/6', [ ] );
	}
}