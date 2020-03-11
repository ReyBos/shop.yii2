<?php

namespace app\controllers;

use app\controllers\AppController;
use app\models\Category;
use app\models\Product;

class ProductController extends AppController
{
    public function actionView($id) 
    {
        $product = Product::findOne($id);
//        $product = Product::find()->with('category')->where(['id' => $id])->limit(1)->one();
        
        return $this->render('view', compact('product'));
    }
}
