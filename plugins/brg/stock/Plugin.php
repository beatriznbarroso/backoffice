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
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    // public function register()
    // {

    // }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    // public function boot()
    // {

    // }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Brg\Stock\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

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
                ],
            ],
        ];
    }
}
