<?php namespace Brg\Stock\Controllers;

use BackendMenu;
use Carbon\Carbon;
use Backend\Classes\Controller;
use Brg\Stock\Models\Component as ComponentModel;
use Brg\Stock\Classes\LaravelExcelHelper as LaravelExcelHelper;
/**
 * Components Back-end Controller
 */
class Components extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public $requiredPermissions = ['Brg.stock.manage_components'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Brg.Stock', 'stock', 'components');
    }

    public function onExportComponentsBackOffice(){
        $backend_user = \BackendAuth::getUser();
        $ip = \Request::getClientIp(true);
        $components = ComponentModel::all();


        if($backend_user && $ip && $components) {
            $rows = $data = [];

            $headers = [
                'Name',
                'Category',
                'Reference',
                'Cost (in Cents)',
                'Weigth (in Grams)',
                'Quantity',
                'Quantity Alert',
                'Supplier Name',
                'Is Recyclable',
                'Created At',
                'Deleted At'
            ];

            array_push($rows, $headers);

            foreach ($components as $component) {
                try {
                    $data = [
                        $component->name,
                        $component->category,
                        $component->reference,
                        $component->cost,
                        $component->weight,
                        $component->quantity,
                        $component->quantity_alert,
                        $component->supplier_name,
                        $component->is_recyclable == true ? 'Yes' : 'No',
                        $component->created_at,
                        $component->deleted_at
                    ];

                    array_push($rows, $data);
                }
                catch (\Exception $e) {
                    trace_log('[This component could not be exported: '.$component->id.'] '.$e->getMessage().'. (Line '.$e->getLine().' at '.$e->getFile().')'); 
                }
            }

            return LaravelExcelHelper::exportCustom('Components '.Carbon::now()->format('Y-m-d'), $rows);
        }
    }
}
