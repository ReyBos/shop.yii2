<?php if (!empty($session['cart'])) : ?>

<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th></th>
                <th>Наименование</th>
                <th>Количество</th>
                <th>Цена</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($session['cart'] as $id => $item) : ?>
            <tr>
                <td><?= $item['img'] ?></td>
                <td><?= $item['name'] ?></td>
                <td><?= $item['qty'] ?></td>
                <td><?= $item['price'] ?></td>
                <td><span class="glyphicon glyphicon-remove text-danger del-item" aria-hidden="true"></span></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="4">Товаров: </td>
                <td><?= $session['cart.qty'] ?></td>
            </tr><tr>
                <td colspan="4">На сумму: </td>
                <td><?= $session['cart.sum'] ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php else: ?>

<h3>Корзина пуста</h3>

<?php endif; ?>
