<?php namespace Brg\Stock\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Brg\Stock\Models\Product as ProductModel;
use Brg\Stock\Classes\ProductExport as ProductExport;
use Brg\Stock\Classes\XlsHelper;

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
        $products = ProductModel::all();

        if($products) {
            $rows = $data = [];

            $headers = [
                'Id',
                'Code',
                'Name',
                'Collection Name',
                'Price',
                'Silver Quantity',
                'Case Price',
                'Components Cost',
                'Production Status',
                'Created At',
                'Updated At',
                'Deleted At'
            ];

            array_push($rows, $headers);

            foreach ($products as $product) {
                try {
                    $data = [
                        $product->id,
                        $product->code,
                        $product->name,
                        $product->collection ? $product->collection->name : null,
                        $product->price,
                        $product->silver_quantity,
                        $product->case_price,
                        $product->sumComponentsCost(),
                        $product->production_status ? 'On' : 'Off',
                        $product->created_at,
                        $product->updated_at,
                        $product->deleted_at
                    ];

                    array_push($rows, $data);
                }
                catch (\Exception $e) {
                    trace_log('[This product could not be exported: '.$component->id.'] Error exporting products: '.$e->getMessage().'. (Line '.$e->getLine().' at '.$e->getFile().')'); 
                }
            }
            return XlsHelper::exportCustom('Products', $rows, false);
        }
    }

    // public function onExportProductsBackOffice(){
    //     $backend_user = \BackendAuth::getUser();
    //     $ip = \Request::getClientIp(true);

    //     if($backend_user && $ip) {
    //         return Excel::download(new ProductExport, 'products_export.xlsx');
    //     }
    // }

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

    public function onRevealSimulatorResult() {
        $post = post();
        $products = $post['products'];
        $quantities  = $post['order-quantity'];

        if($products) {
            $rows = $data = [];
            for($i = 0; $i < count($products); $i++) {
                $product = ProductModel::find($products[$i]);

                foreach($product->components as $component) {
                    try {
                        $data = [
                            $product->name,
                            $quantities[$i],
                            $component->name,
                            $component->quantity,
                            $component->quantity_alert,
                            $component->pivot->component_quantity,
                            $component->pivot->component_quantity * $quantities[$i],
                            $component->quantity - $component->pivot->component_quantity * $quantities[$i]
                        ];
    
                        array_push($rows, $data);
                    }
                    catch (\Exception $e) {
                        trace_log('[This product could not be exported: '.$component->id.'] Error exporting products: '.$e->getMessage().'. (Line '.$e->getLine().' at '.$e->getFile().')'); 
                    }
                }
            }
        }
        return [ 'result' => $this->makePartial('simulator-result', ['components'=>$rows] )];
    }
}
