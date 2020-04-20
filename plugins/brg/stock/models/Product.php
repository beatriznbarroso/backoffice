<?php namespace Brg\Stock\Models;

use Model;
use Brg\Stock\Models\Settings as SettingsModel;

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
    public $hasMany = [];
    public $belongsTo = [
        'collection' => 'Brg\Stock\Models\Collection'
    ];
    public $belongsToMany = [
        'components' => [
            'Brg\Stock\Models\Component', 
            'table' => 'brg_stock_product_components', 
            'timestamps' => true]
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [
        'product_photos' => 'System\Models\File'
    ];


    public function beforeSave() {
        if($this->production_status == true) {
            
            $silver_price = SettingsModel::get('silver_price');
            $bag_price = SettingsModel::get('bag_price');
            $case_price = SettingsModel::get('case_price');
            $silver_quantity = $this->calculateSilverQuantity();
            $components_cost = $this->sumComponentsCost();

            $this->price = $bag_price + $case_price + $this->labour_cost + $components_cost + ($silver_quantity * $silver_price);
        }
    }

    public function calculateSilverQuantity() {
        $components = $this->components;
        $total_components_weight = 0;
        
        for($i=0; $i < count($components); $i++) {
            $total_components_weight +=$components[$i]->weight;
        }

        $this->silver_quantity = $total_components_weight;
        return $this->silver_quantity;
    }

    public function sumComponentsCost() {
        $components_cost = $this->components->sum('cost');
        return $components_cost;
    }

} 
