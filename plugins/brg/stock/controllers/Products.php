<?php namespace Brg\Stock\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Brg\Stock\Models\Product as ProductModel;
use Brg\Stock\Classes\ProductExport as ProductExport;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Products Back-end Controller
 */
class Products extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';
    
    public $requiredPermissions = ['brg.stock.manage_products'];

    public function __construct() {
        parent::__construct();

        BackendMenu::setContext('Brg.Stock', 'stock', 'products');
    }

    public function onExportProductsBackOffice(){
        $backend_user = \BackendAuth::getUser();
        $ip = \Request::getClientIp(true);

        if($backend_user && $ip) {
            return Excel::download(new ProductExport, 'products_export.xlsx');
        }
    }

    public function onOrderProducts(){
        $data = post();
        $product = ProductModel::find($data['product_id']);

        if($product && $data['product_number']) {
            list($result, $message) = $product->orderMoreProducts($data['product_number']);
        }
        return \Redirect::refresh();
    }


    public function onRenderSimulatorProductsOrder(){
        $products = ProductModel::all();
        return ['result'=>$this->makePartial('form_products_order' ,['products' => $products])];
    }

    public function onRevealSimulatorResult() {
        $data = post();

        \Log::debug(json_encode($data));

        $products = $data['product_ids'];
        $quantities  = $data['amounts'];
        \Log::debug(json_encode($products));
        \Log::debug(json_encode($quantities));
        // Checking if campaign id that comes from form is a valid campaign id
        // if(in_array($campaign_id, $valid_campaigns_ids)) {
        //     if((count($names) == count($amounts)) &&  $email) {
        //         $campaign = CampaignModel::find($campaign_id);
        //         $vouchers = collect([]);
        //         for($i=0; $i<count($amounts); $i++) {
        //             // Converting Amount to Cents
        //             $amount = intval(strval(floatval(preg_replace("/[^0-9.]/", "", str_replace(',','.',$amounts[$i]))) * 100));
                    
        //             // Putting DB details referring to target details
        //             $details = 'Voucher destined to '.$names[$i].' Bought by '.$data['email'];
        //             // (($data['address'] == ''))? $delivery_method = 'email' : $delivery_method = 'post_office';

        //             // Creating a voucher with no profile just with amount and campaign general characteristics           
        //             $voucher = $campaign->createCampaignVoucher(null, null, $amount, null, null, $details, null, 'email', 'transfer_gp_iban');
        //             $vouchers->push($voucher);
        //         }  
        //         if($this->sendGiftCardEmail($vouchers, $data['email'], null, null)) {
        //             return ['#signup-form' => $this->renderPartial('giftcards/giftcard-created')];
        //         }
        //         else {
        //             $error_message = \Lang::get('powerparity.crowdlending::lang.generic.error');
        //         }
        //     }
        //     else {
        //         $error_message = \Lang::get('powerparity.crowdlending::lang.generic.inputs_required');
        //     }
        // }
        // else {
        //     $error_message = \Lang::get('powerparity.crowdlending::lang.voucher.campaign_not_found');
        // }
        // return ['.alerts' => $this->renderPartial('components/alert-error', ['message' => $error_message])];
    }

    public function onSimulateProductsOrder() {
        $data = post();
        \Log::debug(json_encode($data));
    }
}
