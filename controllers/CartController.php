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
        $this->clearCart($session);
        
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
            $order->qty = $session['cart.qty'];
            $order->sum = $session['cart.sum'];
            
            if ($order->save()) {
                $this->saveOrderItems($session['cart'], $order->id);
                \Yii::$app->mailer->compose('order', compact('session'))
                    ->setFrom(['andreybosiy@yandex.ru' => 'shop.yii2'])
                    ->setTo($order->email)
                    ->setSubject('Заказ')
                    ->send();
                
                \Yii::$app->session->setFlash('success', 'Ваш заказ принят. Менеджер вскоре свяжется с Вами.');
                $this->clearCart($session);
                
                return $this->refresh();
                
            } else {
                \Yii::$app->session->setFlash('error', 'Ошибка оформления заказа.');
            }
        }
        
        return $this->render('view', compact('session', 'order'));
    }
    
    protected function openSession()
    {
        $session = \Yii::$app->session;
        $session->open();
        
        return $session;
    }
    
    protected function clearCart($session)
    {
        $session->remove('cart');
        $session->remove('cart.qty');
        $session->remove('cart.sum');
    }
    
    protected function saveOrderItems($items, $orderId)
    {
        foreach ($items as $id => $item) {
            $orderItems = new OrderItems();
            $orderItems->order_id = $orderId;
            $orderItems->product_id = $id;
            $orderItems->name = $item['name'];
            $orderItems->price = $item['price'];
            $orderItems->qty_item = $item['qty'];
            $orderItems->sum_item = $item['qty'] * $item['price'];
            $orderItems->save();
        }
    }
}
