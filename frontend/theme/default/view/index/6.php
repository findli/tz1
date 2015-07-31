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
<?
$array = range(1, 100000);
shuffle($array);


// установка дублируемого значения
$array[mt_rand(1, 100000)] = 10;

$begin = microtime(TRUE);
$test = array_fill(1, 100000, 0);
foreach($array as $val)
{
	if($test[$val] == 1) { $number = $val; break; }
	$test[$val] = 1;
}
$end = microtime(TRUE);
echo "Искомое чило: " . $number;
echo '<br>';
echo sprintf("\nВремя выполнения: %.3f", $end - $begin);
echo '<br>';
echo '<br>';
echo '<br>';

$begin = microtime(TRUE);
$computed = array_count_values($array);
$number = array_search(max($computed), $computed);

$end = microtime(TRUE);

echo "Искомое чило: " . $number;
echo '<br>';
echo sprintf("\nВремя выполнения: %.3f", $end - $begin);
?>
</body>
</html>