<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

<div class="container">
    
    <?php
    
    $error = \Yii::$app->session->getFlash('error');
    if ($error) {
        echo '<div class="alert alert-danger col-12 mb-4" role="alert">';
        echo $error;
        echo '</div>';
    }
    
    $success = \Yii::$app->session->getFlash('success');
    if ($success) {
        echo '<div class="alert alert-success col-12 mb-4" role="alert">';
        echo $success;
        echo '</div>';
    }
        
    ?>
    
    <?php if (!empty($session['cart'])) : ?>

    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th>Наименование</th>
                    <th>Количество</th>
                    <th>Цена</th>
                    <th>Сумма</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($session['cart'] as $id => $item) : ?>
                <tr>
                    <td><?= Html::img($item['img'], ['alt' => $item['name'], 'height' => 50]) ?></td>
                    <td><a href="<?= Url::to(['product/view', 'id' => $id]) ?>"><?= $item['name'] ?></a></td>
                    <td><?= $item['qty'] ?></td>
                    <td><?= $item['price'] ?></td>
                    <td><?= $item['price'] * $item['qty'] ?></td>
                    <td><span data-id="<?= $id ?>" class="glyphicon glyphicon-remove text-danger del-item" aria-hidden="true"></span></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="5">Товаров: </td>
                    <td><?= $session['cart.qty'] ?></td>
                </tr><tr>
                    <td colspan="5">На сумму: </td>
                    <td><?= $session['cart.sum'] ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <hr>
    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($order, 'name'); ?>
    <?= $form->field($order, 'email'); ?>
    <?= $form->field($order, 'phone'); ?>
    <?= $form->field($order, 'address'); ?>
    
    <?= Html::submitButton('Заказать', ['class' => 'btn btn-success']); ?>
    
    <?php $form = ActiveForm::end(); ?>

    <?php else: ?>

    <h3>Корзина пуста</h3>

    <?php endif; ?>
    
</div>