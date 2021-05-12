<?php namespace Brg\Stock\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Brg\Stock\Classes\HistoryExport as HistoryExport;
use Maatwebsite\Excel\Facades\Excel;

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

    public function onExportHistories() {
        $backend_user = \BackendAuth::getUser();
        $ip = \Request::getClientIp(true);

        if($backend_user && $ip) {
            return Excel::download(new HistoryExport, 'history_export.xlsx');
        }
    }
}
