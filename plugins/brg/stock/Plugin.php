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
            'description' => 'Plugin for stock',
            'author'      => 'Brg',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

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
            'brg.stock.some_permission' => [
                'tab' => 'Stock',
                'label' => 'Some permission'
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
        return []; // Remove this line to activate

        return [
            'stock' => [
                'label'       => 'Stock',
                'url'         => Backend::url('brg/stock/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['brg.stock.*'],
                'order'       => 500,
            ],
        ];
    }
}
