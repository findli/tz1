<?php
/**
 * Created by PhpStorm.
 * User: ya
 * Date: 1/31/14
 * Time: 1:29 AM
 */
use framework\form\FormHelper;

?>
<form action="<?= $this->getFormUri() ?>">
	<?= FormHelper::input( $model, 'name' ) ?>
	<br/>
	<?= FormHelper::error( $model, 'name' ) ?>
	<br/>
	<?= FormHelper::textArea( $model, 'description' ) ?>
	<br/>
	<?= FormHelper::error( $model, 'description' ) ?>
	<br/>
	<?= FormHelper::checkbox( $model, 'slug' ) ?>
	<br/>
	<?= FormHelper::error( $model, 'slug' ) ?>
	<br/>
	<?= FormHelper::select( $model, 'select1', [ 'k1' => 'v1', 'k2' => 'v2', 'k3' => 'v3' ] ) ?>
	<br/>
	<?= FormHelper::error( $model, 'select1' ) ?>
	<br/>
	<input type="submit" value="Enter"/>
</form>