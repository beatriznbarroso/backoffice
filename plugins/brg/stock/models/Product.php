<?php namespace Brg\Stock\Models;

use Model;
use Validation;
use Brg\Stock\Models\Settings as SettingsModel;
use Brg\Stock\Models\Component as ComponentModel;

/**
 * Product Model
 */
class Product extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'brg_stock_products';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        'histories' => 'Brg\Stock\Models\History'
    ];
    public $belongsTo = [
        'collection' => 'Brg\Stock\Models\Collection'
    ];
    public $belongsToMany = [
        'components' => [
            'Brg\Stock\Models\Component', 
            'table' => 'brg_stock_product_components', 
            'pivot' => 'component_quantity',
            'timestamps' => true]
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'product_photo' => 'System\Models\File'
    ];
    public $attachMany = [];


    public function beforeSave() {
        if($this->isDirty('production_status') && $this->production_status == true) {
            $silver_price = SettingsModel::get('silver_price');
            $bag_price = SettingsModel::get('bag_price');
            $case_price = SettingsModel::get('case_price');
            $silver_quantity = $this->calculateSilverQuantity();
            $components_cost = $this->sumComponentsCost();

            $this->price = $bag_price + $case_price + $this->labour_cost + $components_cost + ($silver_quantity * $silver_price);
        }
    }

    public function afterSave() {
        $components = $this->components;

        foreach($components as $component) {
            $used_quantity = $component->pivot->component_quantity;
            $leftover_quantity = ($component->quantity - $used_quantity < 0 ? 0 : $component->quantity - $used_quantity);

            if ($leftover_quantity < $component->quantity_alert ) {
                \Flash::warning('This component does not have enough quantity for this product');
            } else {
                $component->quantity =  $leftover_quantity;
                $component->save();
            }
        }
        return \Redirect::refresh();
    }

    public function calculateSilverQuantity() {
        $components = $this->components;
        $total_components_weight = 0;
        
        for($i=0; $i < count($components); $i++) {
            $total_components_weight += $components[$i]->weight;
        }

        $this->silver_quantity = $total_components_weight;
        return $this->silver_quantity;
    }

    public function sumComponentsCost() {
        $components = $this->components;
        $components_cost = 0;

        foreach($components as $component) {
            $components_cost += $component->pivot->component_quantity * $component->cost;
        }

        return $components_cost;
    }
} 
