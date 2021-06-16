<?php namespace Brg\Stock\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Brg\Stock\Models\Product as ProductModel;


/**
 * Collection Back-end Controller
 */
class Collections extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    public $requiredPermissions = ['brg.stock.manage_collections'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Brg.Stock', 'stock', 'collections');
    }


    public function onOrderProducts(){
        $data = post();
        $product = ProductModel::find($data['product_id']);

        if($product && $data['product_number']) {
            list($result, $message) = $product->orderMoreProducts($data['product_number']);
            if($result){
                \Flash::success('You can order '.$data['product_number']. ' more products. Will subtract the quantity components used');
            }
            else{
                \Flash::error('Not enough components quantity to make '.$data['product_number'].' products. These are the components that do not have enough quantity: '.$message);
            }
        }
        return \Redirect::refresh();
    }
}
