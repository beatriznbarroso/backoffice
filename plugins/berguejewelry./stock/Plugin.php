<?php namespace BergueJewelry\Stock;

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
            'author'      => 'BergueJewelry',
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
            'berguejewelry.stock.manage_components' => [
                'tab' => 'Stock',
                'label' => 'Manage Components'
            ],
            'berguejewelry.stock.manage_products' => [
                'tab' => 'Stock',
                'label' => 'Manage Products'
            ],
            'berguejewelry.stock.manage_collections' => [
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
                'url'         => Backend::url('berguejewelry/stock/components'),
                'icon'        => 'icon-diamond',
                'permissions' => ['berguejewelry.stock.*'],
                'order'       => 500,
                'sideMenu'=>[
                    'components'=>[
                        'label'       => 'Components',
                        'icon'        => 'icon-cogs',
                        'url'         => Backend::url('berguejewelry/stock/components'),
                        'permissions' => ['berguejewelry.stock.manage_components']
                    ],
                    'products'=>[
                        'label'       => 'Products',
                        'icon'        => 'icon-cube',
                        'url'         => Backend::url('berguejewelry/stock/products'),
                        'permissions' => ['berguejewelry.stock.manage_products']
                    ],
                    'collections'=>[
                        'label'       => 'Collections',
                        'icon'        => 'icon-cubes',
                        'url'         => Backend::url('berguejewelry/stock/collections'),
                        'permissions' => ['berguejewelry.stock.manage_collections']
                    ],
                ],
            ],
        ];
    }
}
