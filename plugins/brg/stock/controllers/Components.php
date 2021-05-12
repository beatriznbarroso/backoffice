<?php namespace Brg\Stock\Controllers;

use BackendMenu;
use Carbon\Carbon;
use Backend\Classes\Controller;
use Brg\Stock\Models\Component as ComponentModel;
use Brg\Stock\Classes\ComponentExport as ComponentExport;
use Maatwebsite\Excel\Facades\Excel;

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
        $backend_user = \BackendAuth::getUser();
        $ip = \Request::getClientIp(true);

        if($backend_user && $ip) {
            return Excel::download(new ComponentExport, 'components_export.xlsx');
        }
    }
}
