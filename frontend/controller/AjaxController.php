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

class AjaxController extends Controller
{

	function actionGet_tree()
	{
		$this->render( 'ajax/get_tree', [
		] );
	}

    //////////////////////////////////////////
    private $parent_id = null;
    private $name = null;

    public function behaviors()
    {
        /*
         * @todo controller ajax only filter for certain actions
         * the same
         */
        return [
            'isAjax' => [
                'class' => \vendor\yasoft\libs\filters\IsAjaxFilter::className(),
                'only'  => ['get_tree', 'insert_category', 'update_category', 'remove_category'],
            ],
        ];
    }

    function getChilds($_id)
    {
        $tree = [];
        $tmp1 = Categories::find()->where(['parent_id' => $_id])->select(['_id', 'name'])->asArray()->all();
        $tmp1 = Categories::instance();
        $tmp1->find('', array('_id', 'name'));
        foreach ($tmp1 as $k => $v) {
            $tree[$k]          = $v;
            $childs            = $this->getChilds($v['_id']);
            $tree[$k]['child'] = ($childs) ? $childs : [];
        }

        return ($tree) ? $tree : null;
    }

    public function __set($var, $val)
    {
        if (isset($this->{$var})) {
            $this->{$var} = $val;
        }
    }

    public function actionGet_tree()
    {
        $home             = Categories::find()->select(['_id', 'name'])->where(['parent_id' => null])->asArray()->one();
        $this->parent_id  = $home['_id'];
        $tree[0]          = $home;
        $tree[0]['child'] = $this->getChilds($home['_id']);
        echo json_encode($tree);
//		p($tree);
    }

    public function actionCreate_test_documents()
    {
        // Home
        $category              = new Categories();
        $category->slug        = 'home';
        $category->ancestors   = [
        ];
        $category->parent_id   = null;
        $category->name        = 'Home';
        $category->description = 'Home';
        echo "status:";
        br();
        d($category->save());

        $home_id = $category->_id;

        // Home -> Outdoors
        $category              = new Categories();
        $category->slug        = 'outdoors';
        $category->ancestors   = [
            [
                'name' => 'Home',
                '_id'  => $home_id,
                'slug' => 'home',
            ],
        ];
        $category->parent_id   = $home_id;
        $category->name        = 'Outdoors';
        $category->description = 'Outdoors';
        $category->save();

        $outdors_id = $category->_id;

        // Home -> Outdoors -> Tools
        $category              = new Categories();
        $category->slug        = 'tools';
        $category->ancestors   = [
            [
                'name' => 'Home',
                '_id'  => $home_id,
                'slug' => 'home',
            ],
            [
                'name' => 'Outdoors',
                '_id'  => $outdors_id,
                'slug' => 'outdoors',
            ],
        ];
        $category->parent_id   = $outdors_id;
        $category->name        = 'Tools';
        $category->description = 'Tools';
        $category->save();

        // Home -> Outdoors -> Seedlings
        $category              = new Categories();
        $category->slug        = 'seedlings';
        $category->ancestors   = [
            [
                'name' => 'Home',
                '_id'  => $home_id,
                'slug' => 'home',
            ],
            [
                'name' => 'Outdoors',
                '_id'  => $outdors_id,
                'slug' => 'outdoors',
            ],
        ];
        $category->parent_id   = $outdors_id;
        $category->name        = 'Seedlings';
        $category->description = 'Seedlings';
        $category->save();
        // Home -> Outdoors -> Planters
        $category              = new Categories();
        $category->slug        = 'planters';
        $category->ancestors   = [
            [
                'name' => 'Home',
                '_id'  => $home_id,
                'slug' => 'home',
            ],
            [
                'name' => 'Outdoors',
                '_id'  => $outdors_id,
                'slug' => 'outdoors',
            ],
        ];
        $category->parent_id   = $outdors_id;
        $category->name        = 'Planters';
        $category->description = 'Planters';
        $category->save();
        // Home -> Outdoors -> Lawn care
        $category              = new Categories();
        $category->slug        = 'lawn-care';
        $category->ancestors   = [
            [
                'name' => 'Home',
                '_id'  => $home_id,
                'slug' => 'home',
            ],
            [
                'name' => 'Outdoors',
                '_id'  => $outdors_id,
                'slug' => 'outdoors',
            ],
        ];
        $category->parent_id   = $outdors_id;
        $category->name        = 'Lawn care';
        $category->description = 'Lawn care';
        $category->save();
    }

    public function actionInsert_category()
    {
        $postJson = json_decode(Yii::$app->request->getPost('postJson'));
        $q        = new Query();
        $q->from('categories');
        $q->where([
            '_id' => new \MongoId($postJson->parentId),
        ]);
        $home          = $q->one();
        $parentId      = $home['_id'];
        $newCategory   = [
            'parent_id'   => $parentId,
            'slug'        => $postJson->newDocument->slug,
            'name'        => $postJson->newDocument->name,
            'description' => $postJson->newDocument->description,
        ];
        $c             = new Categories();
        $c->attributes = $newCategory;
        $c->save();
        $newCategory_Id = $c->_id;

        Categories::generateAncestors($newCategory_Id, $parentId);
        $return         = new \stdClass();
        $return->result = true;
        $return->_id    = $newCategory_Id;
        echo json_encode($return);
    }

    public function actionUpdate_category()
    {
        $postAjax      = json_decode(Yii::$app->request->getPost('postAjax'));
        $affectedCount = Categories::updateAll([
                $postAjax->params,
            ],
            [
                '_id' => new \MongoId($postAjax->id),
            ]);
        echo json_encode((bool)$affectedCount);
    }

    public function actionRemove_category()
    {
        $postAjax      = json_decode(Yii::$app->request->getPost('postAjax'));
        $affectedCount = Categories::deleteAll([
            '_id' => new \MongoId($postAjax->document->_id),
        ]);
        echo json_encode(bool($affectedCount));
    }

    ///////////////////////////////////////////
}