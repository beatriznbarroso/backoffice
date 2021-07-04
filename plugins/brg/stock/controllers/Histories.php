<?php namespace Brg\Stock\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Brg\Stock\Classes\XlsHelper;
use Brg\Stock\Models\History as HistoryModel;
// use Maatwebsite\Excel\Facades\Excel;

/**
 * Histories Back-end Controller
 */
class Histories extends Controller
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    /**
     * @var string Configuration file for the `FormController` behavior.
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string Configuration file for the `ListController` behavior.
     */
    public $listConfig = 'config_list.yaml';

    public $requiredPermissions = ['brg.stock.manage_histories'];


    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Brg.Stock', 'stock', 'histories');
    }

    // public function onExportHistories() {
    //     $backend_user = \BackendAuth::getUser();
    //     $ip = \Request::getClientIp(true);

    //     if($backend_user && $ip) {
    //         return Excel::download(new HistoryExport, 'history_export.xlsx');
    //     }
    // }

    public function onExportHistories(){
        $histories = HistoryModel::all();

        if($histories) {
            $rows = $data = [];

            $headers = [
                'Id',
                'Component Reference',
                'Component Name',
                'Type',
                'Component Used Quantity',
                'Created At',
                'Updated At',
                'Deleted At'
            ];

            array_push($rows, $headers);

            foreach ($histories as $history) {
                try {
                    $data = [
                        $history->id,
                        $history->component_reference,
                        $history->component_name,
                        $history->type,
                        $history->component_used_quantity,
                        $history->created_at,
                        $history->updated_at,
                        $history->deleted_at
                    ];

                    array_push($rows, $data);
                }
                catch (\Exception $e) {
                    trace_log('[This history could not be exported: '.$component->id.'] Error exporting histories: '.$e->getMessage().'. (Line '.$e->getLine().' at '.$e->getFile().')'); 
                }
            }

            return XlsHelper::exportCustom('Histories', $rows, false);
        }
    }
}
