<?php

namespace app\components;

use yii\base\Widget;
use app\models\Category;

class MenuWidget extends Widget
{
    public $tpl;
    public $data; // массив категорий из бд
    public $tree; // результат работы функции, массив дерева
    public $menuHtml; // готовая разметка
    
    public function init() 
    {
        parent::init();
        if ($this->tpl === null) {
            $this->tpl = 'menu';
        }
        $this->tpl . 'php';
    }
    
    public function run() 
    {
        $this->data = Category::find()->indexBy('id')->asArray()->all();
        $this->tree = $this->getTree();
        $this->menuHtml = $this->getMenuHtml($this->tree);
        
        debug($this->tree);
        
        return $this->tpl;
    }
    
    protected function getTree() 
    {
        $tree = [];
        foreach ($this->data as $id => &$node) {
            if (!$node['parent_id']) {
                $tree[$id] = &$node;
                
            } else {
                $this->data[$node['parent_id']]['childs'][$node['id']] = &$node;
            }
        }
        
        return $tree;
    }
    
    protected function getMenuHtml($tree) 
    {
        $str = '';
        foreach ($tree as $category) {
            $str .= $this->catToTemplate(category);
        }
        
        return $str;
    }
    
    protected function catToTemplate($category)
    {
        ob_start();
        include __DIR__ . '/menu/tpl/' . $this->tpl;
        
        return ob_get_clean();
    }
}
