<?php namespace Brg\Stock\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Brg\Stock\Models\Product as ProductModel;
use Brg\Stock\Models\Collection as CollectionModel;
use Brg\Stock\Classes\XlsHelper;

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

    public function onExportCollections(){
        $collections = CollectionModel::all();

        if($collections) {
            $rows = $data = [];

            $headers = [
                'Id',
                'Name',
                'Status',
                'Start Date',
                'End Date',
                'Created At',
                'Updated At',
                'Deleted At'
            ];

            array_push($rows, $headers);

            foreach ($collections as $collection) {
                try {
                    $data = [
                        $collection->id,
                        $collection->name,
                        $collection->status ? 'On' : 'Off',
                        $collection->start_date,
                        $collection->end_date,
                        $collection->created_at,
                        $collection->updated_at,
                        $collection->deleted_at
                    ];

                    array_push($rows, $data);
                }
                catch (\Exception $e) {
                    trace_log('[This collection could not be exported: '.$component->id.'] Error exporting collections: '.$e->getMessage().'. (Line '.$e->getLine().' at '.$e->getFile().')'); 
                }
            }

            return XlsHelper::exportCustom('Collections', $rows, false);
        }
    }
}
