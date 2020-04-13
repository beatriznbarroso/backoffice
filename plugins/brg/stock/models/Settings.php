<?php namespace Brg\Stock\Models;

use Model;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'brg_stock_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';

    public $requiredPermissions = [
        'brg.stock.manage_brg_settings'
    ];
}