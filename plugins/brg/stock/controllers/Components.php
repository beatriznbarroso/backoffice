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

    public $requiredPermissions = ['Brg.stock.manage_components'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Brg.Stock', 'stock', 'components');
    }

    public function onGenerateComponentQuantityForm() {
        $component_id = post('component_id');
        $component = ComponentModel::find($component_id);

        if($component){
            return ['result'=>$this->makePartial('form_generate_component_quantity_form', ['component_id'=>$component_id])];
        }
        else {
            \Flash::error('Component not found');
        }
        return \Redirect::refresh();
    }
}
