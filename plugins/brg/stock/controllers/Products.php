<?php namespace Brg\Stock\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Brg\Stock\Models\Product as ProductModel;
use Brg\Stock\Classes\LaravelExcelHelper as LaravelExcelHelper;


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

    public function onExportProductsBackOffice(){
        $backend_user = \BackendAuth::getUser();
        $ip = \Request::getClientIp(true);
        $products = ProductModel::all();


        if($backend_user && $ip && $products) {
            $rows = $data = [];

            $headers = [
                'Name',
                'Code',
                'Collection',
                'Price (in Cents)',
                'Silver Quantity',
                'Labour Cost (in cents)',
                'Production Status',
                'Stop Selling',
                'Created At',
                'Deleted At'
            ];

            array_push($rows, $headers);

            foreach ($products as $product) {
                try {
                    $data = [
                        $product->name,
                        $product->code,
                        $product->collection->name,
                        $product->price,
                        $product->weight,
                        $product->quantity,
                        $product->quantity_alert,
                        $product->labour_cost,
                        $product->production_status == true ? 'Yes' : 'No',
                        $product->stop_selling == true ? 'Yes' : 'No',
                        $product->created_at,
                        $product->deleted_at
                    ];

                    array_push($rows, $data);
                }
                catch (\Exception $e) {
                    trace_log('[This product could not be exported: '.$product->id.'] '.$e->getMessage().'. (Line '.$e->getLine().' at '.$e->getFile().')'); 
                }
            }

            return LaravelExcelHelper::exportCustom('Products ', $rows);
        }
    }
}
