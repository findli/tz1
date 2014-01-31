<?php
/**
 * Created by PhpStorm.
 * User: ya
 * Date: 1/31/14
 * Time: 10:48 AM
 */

namespace framework\form;


class FormHelper
{
	public static function input( $model, $name )
	{
		return '<input type="text" name="' . $name . '" value="' . $model->get( $name ) . '">';
	}

	public static function checkbox( $model, $name )
	{
		return '<input type="checkbox" name="' . $name . '" ' . ( ( $model->get( $name ) ) ? 'checked="checked"' : '' ) . ' > ';
	}

	public static function textArea( $model, $name )
	{
		return '<textarea name = "' . $name . '" >' . $model->get( $name ) . '</textarea>';
	}

	public static function radio( $model, $name, $values )
	{
		$return = '';;
		foreach ( $values as $k1 => $v1 ) {
			$return .= '<input type = "radio" name = "' . $name . '" value = "' . $v1 . '" ' . ( ( $k1 === $model->get( $name ) ) ? 'checked' : '' ) . ' > ';
		}

		return $return;
	}

	public static function select( $model, $name, $values )
	{
		$return = '<select name = "' . $name . '" > ' . PHP_EOL;
		foreach ( $values as $k1 => $v1 ) {
			$return .= '<option name = "' . $name . '" value = "' . $k1 . '" ' . ( ( $k1 === $model->get( $name ) ) ? 'selected' : '' ) . ' >' . $v1 . '</option>' . PHP_EOL;
		}
		$return .= '</select > ' . PHP_EOL;

		return $return;
	}

	public static function error( $model, $name )
	{
		if ( $error = $model->getError( $name ) ) {
			return '<div class="form-error">' . $error . '</div>';
		}
	}
} 