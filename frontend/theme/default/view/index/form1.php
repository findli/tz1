<?php
/**
 * Created by PhpStorm.
 * User: ya
 * Date: 1/31/14
 * Time: 1:29 AM
 */
use framework\form\FormHelper;

?>
<form action="<?= $this->getFormUri() ?>" enctype="application/x-www-form-urlencoded" method="post">
	<?= FormHelper::label( $model, 'username' ) ?>
	<br/>
	<?= FormHelper::input( $model, 'username' ) ?>
	<br/>
	<?= FormHelper::error( $model, 'username' ) ?>
	<br/>
	<?= FormHelper::textArea( $model, 'password' ) ?>
	<br/>
	<?= FormHelper::error( $model, 'password' ) ?>
	<br/>
	<?= FormHelper::checkbox( $model, 'rememberMe' ) ?>
	<br/>
	<?= FormHelper::error( $model, 'rememberMe' ) ?>
	<br/>
	<? /*= FormHelper::select( $model, 'select1', [ 'k1' => 'v1', 'k2' => 'v2', 'k3' => 'v3' ] ) */ ?><!--
	<br/>
	<? /*= FormHelper::error( $model, 'select1' ) */ ?>
	<br/>-->
	<input type="submit" value="Enter"/>
</form>