<?php namespace BergueJewelry\Stock\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Collection Back-end Controller
 */
class Collection extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public $requiredPermissions = ['berguejewelry.stock.manage_collections'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('BergueJewelry.Stock', 'stock', 'collection');
    }
}
