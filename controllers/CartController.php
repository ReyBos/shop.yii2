<?php

namespace app\controllers;

use app\models\Product;
use app\models\Cart;
use app\models\Order;
use app\models\OrderItems;

class CartController extends AppController 
{
    public function actionAdd()
    {
        $id = \Yii::$app->request->get('id');
        $qty = (int) \Yii::$app->request->get('qty') ? (int) \Yii::$app->request->get('qty') : 1;
        
        $product = Product::findOne($id);
        if (empty($product)) {
            
            return false;
        }
        
        $session = $this->openSession();
        
        $cart = new Cart();
        $cart->addToCart($product, $qty);
        
        if (!\Yii::$app->request->isAjax) {
            
            return $this->redirect(\Yii::$app->request->referrer);
        }
        
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }
    
    public function actionClear() 
    {
        $session = $this->openSession();
        
        $session->remove('cart');
        $session->remove('cart.qty');
        $session->remove('cart.sum');
        
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }
    
    public function actionDelItem()
    {
        $id = \Yii::$app->request->get('id');
        $session = $this->openSession();
        
        $cart = new Cart();
        $cart->recalc($id);
        
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }
    
    public function actionShow()
    {
        $session = $this->openSession();
        
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }
    
    public function actionView()
    {
        $session = $this->openSession();
        $this->setMeta('Корзина');
        
        $order = new Order();
        
        if ($order->load(\Yii::$app->request->post())) {
            debug(\Yii::$app->request->post());
        }
        
        return $this->render('view', compact('session', 'order'));
    }
    
    private function openSession()
    {
        $session = \Yii::$app->session;
        $session->open();
        
        return $session;
    }
}
