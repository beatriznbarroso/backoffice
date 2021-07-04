<?php namespace Brg\Stock\Controllers;

use BackendMenu;
use Carbon\Carbon;
use Backend\Classes\Controller;
use Brg\Stock\Models\Component as ComponentModel;
use Brg\Stock\Classes\ComponentExport as ComponentExport;
use Brg\Stock\Classes\XlsHelper;

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

    public $requiredPermissions = ['brg.stock.manage_components'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Brg.Stock', 'stock', 'components');
    }

    public function onExportComponentsBackOffice(){
        $components = ComponentModel::all();

        if($components) {
            $rows = $data = [];

            $headers = [
                'Id',
                'Name',
                'Reference',
                'Cost',
                'Category',
                'Weight',
                'Quantity',
                'Quantity Alert',
                'Supplier Name',
                'Created At',
                'Updated At',
                'Deleted At'
            ];

            array_push($rows, $headers);

            foreach ($components as $component) {
                try {
                    $data = [
                        $component->id,
                        $component->name,
                        $component->reference,
                        $component->cost,
                        $component->category ? $component->category->name : null,
                        $component->weight,
                        $component->quantity,
                        $component->quantity_alert,
                        $component->supplier_name,
                        $component->created_at,
                        $component->updated_at,
                        $component->deleted_at
                    ];

                    array_push($rows, $data);
                }
                catch (\Exception $e) {
                    trace_log('[This component could not be exported: '.$component->id.'] Error exporting components: '.$e->getMessage().'. (Line '.$e->getLine().' at '.$e->getFile().')'); 
                }
            }

            return XlsHelper::exportCustom('Components', $rows, false);
        }
    }

    // public function onExportComponentsBackOffice(){
    //     $backend_user = \BackendAuth::getUser();
    //     $ip = \Request::getClientIp(true);

    //     if($backend_user && $ip) {
    //         return Excel::download(new ComponentExport, 'components_export.xlsx');
    //     }
    // }
}
