<?php namespace Brg\Stock\Models;

use Model;
use Validation;
use Brg\Stock\Models\History as HistoryModel;

/**
 * Component Model
 */
class Component extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'brg_stock_components';

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
    public $rules = [
        'quantity' => 'required|min:0',
        'quantity_alert' => 'required|min:0',
    ];

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
        'category' => 'Brg\Stock\Models\Category'
    ];
    public $belongsToMany = [
        'products' => ['Brg\Stock\Models\Product', 
            'table' => 'brg_stock_product_components', 
            'timestamps' => true]
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'photo' => 'System\Models\File'
    ];
    public $attachMany = [];

    public function afterSave() {
        if($this->isDirty('quantity')) {
            $original_quantity = $this->getOriginal('quantity');
            $current_quantity = $this->quantity;

            if($current_quantity >= $original_quantity) {
                $type = 'Addition';
                $component_quantity_used = $current_quantity - $original_quantity;
            }
            else {
                $type = 'Substraction';
                $component_quantity_used = -($current_quantity - $original_quantity);
            }
            $this->addHistory($component_quantity_used, $type);
        }
        return \Redirect::refresh();
    }

    public function addHistory($component_quantity_used, $type) {
        $new_history = new HistoryModel();

        $new_history->component_id = $this->id;
        $new_history->component_name = $this->name;
        $new_history->component_reference = $this->reference;
        $new_history->type = $type;
        $new_history->component_used_quantity = $component_quantity_used;
        $new_history->save();
    }
}
