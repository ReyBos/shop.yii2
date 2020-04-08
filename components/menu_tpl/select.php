<option 
    value="<?= $category['id'] ?>" 
    <?= $category['id'] == $this->model->parent_id ? 'selected' : '' ?> 
    <?= $category['id'] == $this->model->id ? 'disabled' : '' ?>
>
    <?= $tab . $category['name'] ?>
</option>

<?php if (isset($category['childs'])) : ?>
<ul>
    <?= $this->getMenuHtml($category['childs'], $tab . '-') ?>
</ul>
<?php endif; ?>
