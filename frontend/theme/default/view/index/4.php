<!doctype html>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
<a href="index">Назад</a>
<br>
<br>
<table border="1">
	<?
	foreach ( $result as $v ) :
		?>
		<tr>
			<td>
				<?
				echo $v[ 'counter_pid' ];
				?>
			</td>
		</tr>
		<?
	endforeach;
	?>
</table>
</body>
</html>