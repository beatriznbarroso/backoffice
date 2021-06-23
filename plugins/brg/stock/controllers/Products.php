<?php namespace Brg\Stock\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Brg\Stock\Models\Product as ProductModel;
use Brg\Stock\Classes\ProductExport as ProductExport;
use Maatwebsite\Excel\Facades\Excel;

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
    
    public $requiredPermissions = ['brg.stock.manage_products'];

    public function __construct() {
        parent::__construct();

        BackendMenu::setContext('Brg.Stock', 'stock', 'products');
    }

    public function onExportProductsBackOffice(){
        $backend_user = \BackendAuth::getUser();
        $ip = \Request::getClientIp(true);

        if($backend_user && $ip) {
            return Excel::download(new ProductExport, 'products_export.xlsx');
        }
    }

    public function onOrderProducts(){
        $data = post();
        $product = ProductModel::find($data['product_id']);

        if($product && $data['product_number']) {
            list($result, $message) = $product->orderMoreProducts($data['product_number']);
        }
        return \Redirect::refresh();
    }


    public function onRenderSimulatorProductsOrder(){
        $products = ProductModel::all();
        return ['result'=>$this->makePartial('form_products_order' ,['products' => $products])];
    }

    public function onSimulateProductsOrder() {
        $data = post();
        \Log::debug(json_encode($data));
    }
}
