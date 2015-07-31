<!doctype html>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Задание 3</title>
	<link rel="stylesheet" href="/theme/dist/themes/default/style.min.css"/>
</head>
<body>
<a href="index">Назад</a>
<br>
<br>
<div id="jstree_demo_div"></div>
<script src="/theme/dist/libs/jquery-1.10.2.min.js"></script>
<script src="/theme/dist/jstree.min.js"></script>
<script type="text/javascript">
	$(function () {
		var jsTree = $('#jstree_demo_div');
		jsTree.jstree({
			'core': {
				'data': {
					'url': '3ajax',
					dataType: 'json'
				}
			}
		}).on('loaded.jstree', function () {
			jsTree.jstree('open_all');
		});
	});
</script>
</body>
</html>