<?php
/**
 * Created by PhpStorm.
 * User: ya
 * Date: 1/31/14
 * Time: 10:48 AM
 */

namespace framework\form;
use framework\Base;

class FormHelper
{
	public static function label( $model, $name )
	{
		return '<label for="' . Base::getClass( get_class( $model ) ) . '[' . $name . ']' . '">' . $model->getLabel( $name ) . '</label>';
	}

	public static function input( $model, $name )
	{
		return '<input type="text" name="' . Base::getClass( get_class( $model ) ) . '[' . $name . ']' . '" id="' . Base::getClass( get_class( $model ) ) . '[' . $name . ']' . '" value="' . $model->get( $name ) . '">';
	}

	public static function checkbox( $model, $name )
	{
		return '<input type="checkbox" name="' . Base::getClass( get_class( $model ) ) . '[' . $name . ']' . '" id="' . Base::getClass( get_class( $model ) ) . '[' . $name . ']' . '" ' . ( ( $model->get( $name ) ) ? 'checked="checked"' : '' ) . ' > ';
	}

	public static function textArea( $model, $name )
	{
		return '<textarea name = "' . Base::getClass( get_class( $model ) ) . '[' . $name . ']' . '" id="' . Base::getClass( get_class( $model ) ) . '[' . $name . ']' . '" >' . $model->get( $name ) . '</textarea>';
	}

	public static function radio( $model, $name, $values )
	{
		$return = '';;
		foreach ( $values as $k1 => $v1 ) {
			$return .= '<input type = "radio" name = "' . Base::getClass( get_class( $model ) ) . '[' . $name . ']' . '" id="' . Base::getClass( get_class( $model ) ) . '[' . $name . ']' . '" value = "' . $v1 . '" ' . ( ( $k1 === $model->get( $name ) ) ? 'checked' : '' ) . ' > ';
		}

		return $return;
	}

	public static function select( $model, $name, $values )
	{
		$return = '<select name = "' . Base::getClass( get_class( $model ) ) . '[' . $name . ']' . '" > ' . PHP_EOL;
		foreach ( $values as $k1 => $v1 ) {
			$return .= '<option name = "' . Base::getClass( get_class( $model ) ) . '[' . $name . ']' . '" id="' . Base::getClass( get_class( $model ) ) . '[' . $name . ']' . '" value = "' . $k1 . '" ' . ( ( $k1 === $model->get( $name ) ) ? 'selected' : '' ) . ' >' . $v1 . '</option>' . PHP_EOL;
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