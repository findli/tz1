/**
 * Created by ya on 1/17/14.
 */
nestedTree = {};
nestedTree.getBreadcrumbsFromArray = function (breadcrumbsArray) {
    parentClass = breadcrumbsArray[breadcrumbsArray.length - (breadcrumbsArray.length - 1) - 1];
    $(breadcrumbsArray).each(function (k1, v1) {
        if (k1 != 0) {
            parentClass = parentClass + '-' + v1;
        }
    })
    return parentClass;
}
nestedTree.getArrayFromBreadcrumbs = function (breadcrumbsString) {
    return explode('-', breadcrumbsString);
}
function findUpTag(el, tag) {
    el = el[0];
    tag = tag.toUpperCase();
			console.log('function findUpTag');
			console.log(el);
			console.log(tag);
    while (el.parentNode) {
        el = el.parentNode;
//				if ($(el).attr('hasnext') === 'has') {
//					console.log("$(el).attr('hasnext')");
//					console.log($(el).attr('hasnext'));
//					console.log('el.tagName', el.tagName);
//				}
        if (el.tagName === tag && $(el).attr('hasnext') === 'has') {
//					console.log($(el).attr('class'));
//					console.log('el', el);

            var cssClass = $(el).attr('class');
            el.removeAttribute('hasnext');
            return  cssClass;
        } else {
            if (el.tagName === tag && $(el).attr('hasnext') === 'not') {
                el.removeAttribute('hasnext');
            }
//					console.log($(el).attr('class'));
        }
    }
    return undefined;
}
nestedTree.getLi = function(newRowClass, dataObject){
    var ret = $(document.createElement('li')).attr('class', newRowClass).text(dataObject.name + '; ' + newRowClass)
        .attr('mongoid', dataObject._id.$id)
        .append($(document.createElement('input')).attr('type', 'button').attr('value', 'add').attr('target', 'add'))
        .append($(document.createElement('input')).attr('type', 'button').attr('value', 'del').attr('target', 'delete'))
        .append($(document.createElement('input')).attr('type', 'button').attr('value', 'edit').attr('target', 'edit'));
    return ret;
}
nestedTree_drawTree_tmp2 = undefined;
// parentClass use only once for definition tree place
// breadcrumbsArray contain elements from those can create parent class
nestedTree.drawTree = function (treeJson, breadcrumbsArray, parentClass) {
//			console.log('function drawTree(treeJson = ' + '' + ', breadcrumbsArray = ' + breadcrumbsArray + ', parentClass = ' + parentClass);
    if (parentClass == undefined) {
        parentClass = this.getBreadcrumbsFromArray(breadcrumbsArray)
    }
    var ulId = treeJson[0]._id.$id;
    var ul = $(document.createElement('ul')).attr('id', ulId);
    $("." + parentClass).append(ul);
    for (var i = 0; i < treeJson.length; i++) {
        var k1 = i;
//				$(treeJson).each(function (k1, treeJson[i]) {
//				console.group('loop');
        ++k1;
        if (nestedTree_drawTree_tmp2 !== undefined) {
            breadcrumbsArray = nestedTree_drawTree_tmp2;
            nestedTree_drawTree_tmp2 = undefined;
        }
//				console.log("breadcrumbsArray: ");
//				console.log(breadcrumbsArray);
        if (k1 == 1) {
//					console.log('push', k1);
            breadcrumbsArray.push(k1);
        } else {
//					console.log('removeKey', breadcrumbsArray.length - 1);
            breadcrumbsArray = removeKey(breadcrumbsArray, breadcrumbsArray.length - 1);
//					console.log('push', k1);
            breadcrumbsArray.push(k1);
        }
//				console.log(breadcrumbsArray);
        var newRowClass = this.getBreadcrumbsFromArray(breadcrumbsArray);
//				console.log('newRowClass', newRowClass);

        var li = this.getLi(newRowClass, treeJson[i]);
// tag 1
        if (treeJson[i].child.length > 0 && treeJson[i + 1] != undefined) {
            $(li).attr('hasnext', 'has');
        } else {
            $(li).attr('hasnext', 'not');
        }

        // tag //1
        $("#" + ulId).append(li);
        if (treeJson[i].child.length > 0) {
//					console.log('breadcrumbsArray', breadcrumbsArray);
            this.drawTree(treeJson[i].child, breadcrumbsArray);
        }

        // tag 1
        if (treeJson[i + 1] == undefined) {

            var breadcrumbsString = findUpTag(document.getElementsByClassName(newRowClass), 'li');
//					console.log('breadcrumbsString parent:', breadcrumbsString);
//					console.log('breadcrumbsString', breadcrumbsString);
            if (breadcrumbsString != undefined) {
                breadcrumbsArray = this.getArrayFromBreadcrumbs(breadcrumbsString);
//						console.log('breadcrumbsArray');
//						console.log(breadcrumbsArray);

                var tmp1 = (breadcrumbsArray[breadcrumbsArray.length - 1]) * 1 + 1;
//						console.log('tmp1:', tmp1);
                breadcrumbsArray = removeKey(breadcrumbsArray, breadcrumbsArray.length - 1);

                breadcrumbsArray.push(tmp1 + '');
//						console.log('breadcrumbsArray');
//						console.log(breadcrumbsArray);
                nestedTree_drawTree_tmp2 = breadcrumbsArray;
            }

        }
        // tag //1
//				console.groupEnd('loop');
//				})
    }
}
