<?php namespace Brg\Stock\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

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
}
