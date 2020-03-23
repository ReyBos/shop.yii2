<?php

namespace app\controllers;

use app\controllers\AppController;
use app\models\Category;
use app\models\Product;
use yii\data\Pagination;
use Yii;

class CategoryController extends AppController
{
    public function actionIndex() 
    {
        $hits = Product::find()->where(['hit' => '1'])->limit(6)->all();
        $this->setMeta('E-SHOPPER');
        
        return $this->render('index', compact('hits'));
    }
    
    public function actionView($id)
    {
        $category = Category::findOne($id);
        if (empty($category)) {
            throw new \yii\web\HttpException(404, 'Такой категории нет.');
        }
        
        $query = Product::find()->where(['category_id' => $id]);
        $pages = new Pagination([
            'totalCount' => $query->count(), 
            'pageSize' => 3, 
            'forcePageParam' => false,
            'pageSizeParam' => false,
        ]);
//        $products = Product::find()->where(['category_id' => $id])->all();
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();
        
        $this->setMeta('E-SHOPPER | ' . $category->name, $category->keywords, $category->description);
        
        return $this->render('view', compact('products', 'pages', 'category'));
    }
}
