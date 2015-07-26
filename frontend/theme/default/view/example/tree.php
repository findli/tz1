<?php
/**
 * Created by PhpStorm.
 * User: ya
 * Date: 2/7/14
 * Time: 3:53 PM
 */

?>
<!doctype html>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Tree example</title>
	<meta charset="UTF-8">
	<script type="text/css" src="<?= \framework\ApplicationHelper::get( 'themePath' ) ?>/css/base.css"></script>
	<script type="text/css" src="<?= \framework\ApplicationHelper::get( 'themePath' ) ?>/css/grid.css"></script>
	<script type="text/css" src="<?= \framework\ApplicationHelper::get( 'themePath' ) ?>/css/main.css"></script>
	<script type="text/css" src="<?= \framework\ApplicationHelper::get( 'themePath' ) ?>/css/tree.css"></script>
</head>
<body>
<div class="row"></div>
<div class="container">

	<div class="row">
		<div class="header span3">
			<!--        <h1>CSS Grid</h1>-->
		</div>
		<!--    <div class="search span4 offset4"><input class="search-field" type="text" name="" id=""/><input class="search-button" type="submit" value="Поиск"/></div>-->
	</div>
	<div class="row">
		<!--    <div class="slider span12"></div>-->
	</div>
	<div class="row">
		<!--    <div class="thumb span2"><img src="/images/140x100.gif"></div>-->
		<!--    <div class="thumb span2"><img src="/images/140x100.gif"></div>-->
		<!--    <div class="thumb span2"><img src="/images/140x100.gif"></div>-->
		<!--    <div class="thumb span2"><img src="/images/140x100.gif"></div>-->
		<!--    <div class="thumb span2"><img src="/images/140x100.gif"></div>-->
		<!--    <div class="thumb span2"><img src="/images/140x100.gif"></div>-->
	</div>
	<div class="row">
		<div class="sidebar span5">
			<style type="text/css">
				.node div {
					position: relative;
				}
			</style>
			<div class="tree"></div>

			<!--<nav>
				<ul>
					<li>
						<a href="">Item 1</a>
					</li>
				</ul>
			</nav>-->
		</div>
		<div class="content span7">
			<!--        <h2>Lorem ipsum dolor sit amet.</h2>-->
		</div>
	</div>

	<div class="row">
		<div class="footer span12">
			<!--        <small>Ipsum quo rem sit voluptatem.</small>-->
		</div>
	</div>
</div>
<script type="text/javascript"
        src="<?= \framework\ApplicationHelper::get( 'themePath' ) ?>/vendor/jquery-2.0.3.js"></script>
<script type="text/javascript"
        src="<?= \framework\ApplicationHelper::get( 'themePath' ) ?>/vendor/selectivizr-min.js"></script>
<script type="text/javascript"
        src="<?= \framework\ApplicationHelper::get( 'themePath' ) ?>/vendor/prefixfree.min.js"></script>
<script type="text/javascript"
        src="<?= \framework\ApplicationHelper::get( 'themePath' ) ?>/js/std/my.js"></script>
<script type="text/javascript"
        src="<?= \framework\ApplicationHelper::get( 'themePath' ) ?>/js/std/fixes.js"></script>
<script type="text/javascript"
        src="<?= \framework\ApplicationHelper::get( 'themePath' ) ?>/js/std/php.js"></script>
<script type="text/javascript"
        src="<?= \framework\ApplicationHelper::get( 'themePath' ) ?>/js/std/tree/draw.js"></script>
<script type="text/javascript">
$(document).ready(function () {

});
/*
 @TODO
 1. expand and hide
 2. checkbox indicated root node for menu like in ozon.ru
 3. on frontside on large resolution menu look like in ozon.ru and on mobile devices look like in sotomore.ru
 */
$(document).ready(function () {

	var mongoWorker = {};
	mongoWorker.insertCategory = function (newDocument, parentId) {
		var post = {
			'newDocument': newDocument,
			'parentId': parentId
		}
		var postJson = JSON.stringify(post);
		$.ajax({
				url: '/ajax/insert_category',
				data: {
					'postJson': postJson
				},
				'type': 'post',
				dataType: 'json',
				cache: false,
				statusCode: {
					404: function () {
						alert('server error! try again later or write admin!');
					}
				}
			}
		).done(function (data) {
				console.group('ajax after 1');
				console.log('data:');
				console.log(data);
				ret = data._id.$id;
                console.log('new Id:');
                console.log(ret);
				console.group('ajax after 2');
				return ret;
			});
	};
	mongoWorker.updateCategory = function (categoryId, newCategorySlug) {
		var slug = newCategorySlug;
		var name = slug;
		var description = slug;
		$.ajax({
				url: '/ajax/update_category',
				data: {
					'slug': slug,
					'name': name,
					'description': description
				},
				dataType: 'json',
				cache: false,
				statusCode: {
					404: function () {
						alert('server error! try again later or write admin!');
					}
				}
			}
		).done(function (data) {
				console.group('ajax after 1');
				console.log(data);
				console.group('ajax after 2');
			});
	};
	mongoWorker.removeCategory = function (categoryId) {
		$.ajax({
				url: '/ajax/remove_category',
				cache: false,
				dataType: 'json',
				data: {

				},
				statusCode: {
					404: function () {
						alert('server error! try later or write to admin!');
					}
				}
			}
		).done(function (data) {
				console.group('ajax after 1');
				console.log(data);
				console.group('ajax after 2');
			});
	};


	$(document).on('click', 'input[target=edit]', function () {

	});
	$(document).on('click', 'input[target=add]', function () {
		console.group('click add node to currentNodeClass:');
		var ul = $(this).parents('ul');
		var parentId = $(ul).attr('id');
		console.log('parentId');
		console.log(parentId);
		var new_category_name = prompt('Enter new category name: ');
		var new_category_slug = prompt('Enter new category slug: ');
		var new_category_descritpion = prompt('Enter new category description: ');

		var newDocument = {};
		newDocument['slug'] = new_category_slug;
		newDocument['name'] = new_category_name;
		newDocument['description'] = new_category_descritpion;

		var newId = mongoWorker.insertCategory(newDocument, parentId);
		// todo после ajax call addLiFunc
        /*
		console.log('newId:');
		console.log(newId);
		newDocument['_id'] = newId;
		var newRowClass = 'class';
        nestedTree.getLi(newRowClass, newDocument);
         */
        return;
		var currentNodeLevel = currentNodeClass.split('node');
//					console.log('parsed: ');
//					console.log(currentNodeLevel);
		var size = $(this).parent().children('div[class*=node]').size();
		console.log('children node size: ' + size);
		var new_category_name = prompt('Enter new category name: ');
		var new_category_slug = prompt('Enter new category slug: ');
		var new_category_descritpion = prompt('Enter new category description: ');
		var new_node = '<div class="node' + currentNodeLevel[1] + '-' + (size + 1) + '">' + new_category + ' - ' + currentNodeLevel[1] + '-' + (size + 1) + '<input type="button" value="add" target="add"/><input type="button" value="delete" target="delete"/>';
		console.log('new node: ', new_node);
		$(this).parent().append(new_node);
		var level = 1;
		var root_node = document.getElementsByClassName('node');
		create_array(root_node, level, false);

		console.group('for ajax: ');


		var newDocument = {};
		newDocument['slug'] = new_category_slug;
		newDocument['name'] = new_category_name;
		newDocument['description'] = new_category_descritpion;

		console.log('newDocument: ');
		console.log(newDocument);

		var parentId = currentNodeLevel[1];
		// test env
		parentId = 'home';
		console.log('parentId: ');
		console.log(parentId);

		mongoWorker.insertCategory(newDocument, parentId);

		console.groupEnd();


		console.groupEnd();
	});
	$(document).on('click', 'input[target=delete]', function () {
		var parentParentNodeClass = $(this).parent().parent().attr('class');
		var currentNodeClass = $(this).parent().attr('class');
		console.group('click delete node to ' + currentNodeClass);
		$(this).parent().remove();
		console.log('parentParentNode children size:', $('.node div[class=' + parentParentNodeClass + '] > div').size());
		console.group('each children');
		var i = 0;
		$('.node div[class=' + parentParentNodeClass + '] > div[class*=node]').each(function () {
			var currentNodeClass = $(this).attr('class');
			console.log('currentNodeClass: ');
			console.log(currentNodeClass);
			console.log(currentNodeClass.length);
			var new_class_prototype = currentNodeClass.substring(0, [currentNodeClass.length - 1]);
			console.log(new_class_prototype);
			var new_class = new_class_prototype + ++i;
			if (currentNodeClass != new_class)
				$('.node div[class=' + currentNodeClass + ']').addClass(new_class).removeClass(currentNodeClass);
		});
		console.groupEnd();
	});

	// example tree:
	var testTree = [
		{
			'_id': '1',
			'slug': 'home',
			'name': 'home',
			'description': 'description home',
			'child': [
				{
					'_id': '2',
					'slug': 'outdoors',
					'name': 'Outdoors',
					'description': 'description Outdoors',
					'child': [
						{
							'_id': '3',
							'slug': 'tools',
							'name': 'Tools',
							'description': 'description Tools',
							'child': []
						},
						{
							'_id': '4',
							'slug': 'seedlings',
							'name': 'Seedlings',
							'description': 'description Seedlings',
							'child': []
						},
						{
							'_id': '5',
							'slug': 'planters',
							'name': 'Planters',
							'description': 'description Planters',
							'child': []
						},
						{
							'_id': '6',
							'slug': 'lawn-care',
							'name': 'Lawn care',
							'description': 'description "Lawn care"',
							'child': []
						}
					]
				},
				{
					'_id': '7',
					'slug': 'lvl2-1-2',
					'name': 'indoors lvl2 1-2',
					'description': 'description lvl2 1-2',
					'child': []
				},
				{
					'_id': '8',
					'slug': 'lvl2-1-3',
					'name': 'road',
					'description': 'description lvl2 1-3',
					'child': [
						{
							'_id': '9',
							'slug': 'tools',
							'name': 'Tools',
							'description': 'description Tools',
							'child': []
						},
						{
							'_id': '10',
							'slug': 'seedlings',
							'name': 'Seedlings',
							'description': 'description Seedlings',
							'child': []
						},
						{
							'_id': '11',
							'slug': 'planters',
							'name': 'Planters',
							'description': 'description Planters',
							'child': []
						},
						{
							'_id': '12',
							'slug': 'lawn-care',
							'name': 'Lawn care',
							'description': 'description "Lawn care"',
							'child': []
						}
					]
				}
			]
		}
	];
    nestedTree.drawTree(testTree, [1], 'tree');

    /*$.ajax({
		'cache': true,
		'url': '/ajax/get_tree',
		'success': function (data) {
			var treeJSON = $.parseJSON(data);
			nestedTree.drawTree(treeJSON, [1], 'tree');
		}
	})*/
});
</script>

</body>
</html>