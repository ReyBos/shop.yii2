<option 
    value="<?= $category['id'] ?>" 
    <?= $category['id'] == $this->model->category_id ? 'selected' : '' ?> 
>
    <?= $tab . $category['name'] ?>
</option>

<?php if (isset($category['childs'])) : ?>
<ul>
    <?= $this->getMenuHtml($category['childs'], $tab . '-') ?>
</ul>
<?php endif; ?>
