<?php namespace Brg\Stock\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Brg\Stock\Models\Component as ComponentModel;

/**
 * Products Back-end Controller
 */
class Products extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';
    
    public $requiredPermissions = ['Brg.stock.manage_products'];

    public function __construct() {
        parent::__construct();

        BackendMenu::setContext('Brg.Stock', 'stock', 'products');
    }

    // Subtracting quantity to components after adding components to products 
    // Need to do it here because of many to many relationship
    public function formAfterSave($model) {
        $components = $model->components;

        foreach($components as $component) {
            $used_quantity = $component->pivot->component_quantity;
            \Log::debug($used_quantity);

            $component = ComponentModel::find($component->id);
            \Log::debug(json_encode($component));
            $component->quantity = $component->quantity - $used_quantity;
            $component->save();
        }    
    }
}
