<?php namespace Brg\Stock;

use Backend;
use System\Classes\PluginBase;

/**
 * Stock Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Stock',
            'description' => 'BackOffice for Stock Management',
            'author'      => 'Brg',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'brg.stock.manage_components' => [
                'tab' => 'Stock',
                'label' => 'Manage Components'
            ],
            'brg.stock.manage_products' => [
                'tab' => 'Stock',
                'label' => 'Manage Products'
            ],
            'brg.stock.manage_collections' => [
                'tab' => 'Stock',
                'label' => 'Manage Collections'
            ],
            'brg.stock.manage_histories' => [
                'tab' => 'Stock',
                'label' => 'Manage Histories'
            ],
            'brg.stock.manage_settings' => [
                'tab' => 'Stock',
                'label' => 'Manage Settings'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'stock' => [
                'label'       => 'Stock',
                'url'         => Backend::url('brg/stock/components'),
                'icon'        => 'icon-diamond',
                'permissions' => ['brg.stock.*'],
                'order'       => 500,
                'sideMenu'=>[
                    'components'=>[
                        'label'       => 'Components',
                        'icon'        => 'icon-cogs',
                        'url'         => Backend::url('brg/stock/components'),
                        'permissions' => ['brg.stock.manage_components']
                    ],
                    'products'=>[
                        'label'       => 'Products',
                        'icon'        => 'icon-cube',
                        'url'         => Backend::url('brg/stock/products'),
                        'permissions' => ['brg.stock.manage_products']
                    ],
                    'collections'=>[
                        'label'       => 'Collections',
                        'icon'        => 'icon-cubes',
                        'url'         => Backend::url('brg/stock/collections'),
                        'permissions' => ['brg.stock.manage_collections']
                    ],
                    'histories'=>[
                        'label'       => 'History',
                        'icon'        => 'icon-history',
                        'url'         => Backend::url('brg/stock/histories'),
                        'permissions' => ['brg.stock.manage_histories']
                    ],
                    'categories'=>[
                        'label'       => 'Categories',
                        'icon'        => 'icon-exchange',
                        'url'         => Backend::url('brg/stock/categories'),
                    ],
                ],
            ],
        ];
    }

    /**
     * Register settings models
     */
    public function registerSettings()
    {
        return [
            'Settings' => [
                'label'       => 'Brg Settings',
                'icon'        => 'icon-sliders',
                'description' => 'General Bergue Configurations.',
                'class'       => 'Brg\Stock\Models\Settings',
                'order'       => 100,
                'keywords'    => 'stock general settings',
                'permissions' => ['brg.stock.manage_brg_settings']
            ]
        ];
    }

    public function register()
    {
        // Console Commands
        $this->registerConsoleCommand(
            'crowdlending:send_component_quantity_email',
            'Brg\Stock\Console\ComponentAlert'
        );
    }

    public function registerMailTemplates()
    {
        return [
            'brg.stock::component_alert',
        ];
    }
}
