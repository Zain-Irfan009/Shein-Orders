<?php

namespace App\Http\Controllers\admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Jobs\ProductInventoryManageJob;
use App\Models\Booking;
use App\Models\Order;
use App\Models\OrderLineItem;
use App\Models\Package;
use App\Models\Product;
use App\Models\Session;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function back;
use function dd;
use function redirect;
use function response;
use function view;

class AdminController extends Controller
{
    public function shop_login(){
        return view('shop_login');
    }
    public function shop_logout(){
        Auth::logout();
        return redirect(route('shop.login'));
    }
    public function index(){


        $orders_count=Order::where('shop_id',Auth::id())->count();
        $sessions_count=Session::count();
        $packages_count=Package::count();

        return view('admin.dashboard',compact('orders_count','sessions_count','packages_count'));
    }



    public function products(Request $request){
        $products=Product::with('has_variant')->where('shop_id',Auth::id())->newQuery();
        if($request->search){
            $products=$products->where('title', 'like', '%' . $request->search . '%');
        }
        $products=$products->paginate(20);

        $products->appends($request->all);
        return view('products',compact('products'));
    }
    public function product_view($id){
        $product=Product::with('has_variant')
            ->where('shop_id',Auth::id())
            ->where('id',$id)
            ->first();

        return view('product_view',compact('product'));
    }
    public function product_update($id,Request $request){
        $product=Product::find($id);

//        dd($request->all(),$result);
        /*$product_data = [
            "product" =>
                [
                    "title" => $product->title,
                ]
        ];
        $product_update = $shop->api()->rest('PUT', '/admin/products/'.$product->shopify_id.'.json', $product_data);*/
//        dd($product,$product_meta_update);

        return back()->with('success','Product updated');
    }



    public function SyncOrders($next=null,$shop=null)
    {

        if($shop==null){
            $shop = Auth::user();
        }else{
            Auth::login($shop);
        }
//        dd($shop);
//        $products = $products['body']['products'];
//        dd($products);

        try{
            $orders = $shop->api()->rest('GET', '/admin/orders.json', [
                'limit' => 250,
                'status' => "any",
                'page_info' => $next
            ]);
//            dd($products);
            foreach ($orders['body']['orders'] as $order) {
                $this->CreateUpdateOrder($order, $shop);
            }
            if (isset($orders['link']['next'])) {

                $this->SyncOrders($orders['link']['next'],$shop);
            }
        }catch (\Exception $exception){
            dd($exception->getMessage());
        }


//        return redirect(route('home'))->with('success','Orders Sync Successfully!');
//        return back()->with('success','Product Sync Successfully!');
    }

    public function CreateUpdateOrder($order, $shop)
    {

        $order = json_decode(json_encode($order), FALSE);
//        dd($order);
        $first_name="";
        $last_name="";
        if(isset($order->customer->first_name)){
            $first_name=$order->customer->first_name;
            $last_name=$order->customer->last_name;
        }
        $shipping_address=null;
        if(isset($order->shipping_address)){
            $shipping_address=json_encode($order->shipping_address);
        }
        $Order=Order::where([
            'shop_id'=>$shop->id,
            'order_id'=>$order->id,
        ])->first();
        if($Order==null){
            $Order=new Order();
            $Order->shop_id=$shop->id;
            $Order->order_id=$order->id;
        }
        $Order->order_name=$order->name;
        $Order->email=$order->email;
        $Order->first_name=$first_name;
        $Order->last_name=$last_name;
        $Order->total_price=$order->total_price;
        $Order->total_discounts=$order->total_discounts;
        $Order->total_tax=$order->total_tax;
        $Order->discount_codes=json_encode($order->discount_codes);
        $Order->fulfillments=json_encode($order->fulfillments);
        $Order->shipping_address=$shipping_address;
        $Order->created_at=Carbon::parse($order->created_at)->toDateString();
        $Order->save();
        foreach ($order->line_items as $line_item){
            $lineItem=OrderLineItem::where([
                'shop_id'=>$shop->id,
                'order_id'=>$order->id,
                'line_item_id'=>$line_item->id,
            ])->first();

            if($lineItem==null){
                $lineItem=new OrderLineItem();
                $lineItem->shop_id=$shop->id;
                $lineItem->order_id=$order->id;
                $lineItem->line_item_id=$line_item->id;
            }
            $lineItem->product_id=$line_item->product_id;
            $lineItem->variant_id=$line_item->variant_id;
            $lineItem->title=$line_item->title;
            $lineItem->variant_title=$line_item->variant_title;
            $lineItem->sku=$line_item->sku;
            $lineItem->vendor=$line_item->vendor;
            $lineItem->quantity=$line_item->quantity;
            $lineItem->price=$line_item->price;
            $lineItem->total_discount=$line_item->total_discount;
            $lineItem->properties=json_encode($line_item->properties);
            $lineItem->created_at=Carbon::parse($order->created_at)->toDateString();
            $lineItem->save();
        }


    }

    public function discount(Request $request)
    {
        $response = Helper::apiClient()->rest('GET', '/admin/price_rules.json');
//        dd($response);
        $discounts = json_decode(json_encode($response['body']->container['price_rules']));
        $discount_status = null;
        foreach ($discounts as $discount) {
            if ($discount->title == $request->discount) {
                $discount_status = 'yes';
            }
        }
        return response()->json([
            'status' => 'success',
            'discount' => $discount_status,
        ]);
    }
    public function cartOrder(Request $request)
    {
        $cart = json_decode(json_encode($request->cart),false);
//         return response()->json([
//             'data' => $cart,
//         ],500);

        $cart_currency=$cart->currency;
        $lineItems = [];
        foreach ($cart->items as $item) {
//                                return response()->json([
//                        'status' => 'log',
//                        'properties' => $item->properties,
//                    ],500);
            if (isset($item->properties) && isset($item->properties->_newPrice)) {
                $data_properties = json_decode(json_encode($item->properties), true);
              /*  $camelCaseData = array_map(function ($value, $key) {
                    return [Str::studly($key) => $value];
                }, $data_properties, array_keys($data_properties));
//             Merge the array with camelCase keys
                $data_properties = call_user_func_array('array_merge', $camelCaseData);*/
                // Remove specified properties
                $customAttributes = [];
                foreach ($data_properties as $key => $value) {
//                    $formattedKey = ucfirst(preg_replace('/(?<!^)([A-Z])/', ' $1', $key)); // Convert CamelCase to Title Case
                    if($value==null){
                        $value="";
                    }
                    $customAttributes[] = [
                        'key' => $key,
                        'value' => $value,
                    ];
                }
//                dd($customAttributes);

                /*$lineItems[] = [
                    'variantId' => "gid://shopify/ProductVariant/$item->variant_id",
                    "quantity" => $item->quantity,
                "originalUnitPrice" => 375 *100,//$item->properties->_newPrice*100
                    "customAttributes" => $customAttributes
                ];*/
                $custom_price = (float) preg_replace('/[^\d.]/', '', $item->properties->_newPrice);

                $lineItems[] =  [
                    "title" => $item->product_title,
//                    "image" => $item->image,
                    "originalUnitPrice" => $custom_price/100,//$item->properties->_newPrice*100
                    "quantity" => $item->quantity,
                    "customAttributes" => $customAttributes
                ];
            }
            else {
                array_push($lineItems, [
                    'variantId' => "gid://shopify/ProductVariant/$item->variant_id",
                    "quantity" => $item->quantity,
                ]);
            }
        }

        /*$draft_order=[
                "financial_status" => "pending",
                "currency" => $cart_currency,
                "line_items" => $items
        ];*/
        $data_gql = [
            'lineItems' => $lineItems,
//            'marketRegionCountryCode' =>"",
            'presentmentCurrencyCode'=> $cart_currency
        ];
//dd($data_gql);
        if (($request->discount)) {
            $priceRules = Helper::apiClient()->rest('GET', '/admin/price_rules.json');
            $discounts = json_decode(json_encode($priceRules['body']->container['price_rules']));
            $applied_discount = null;
            foreach ($discounts as $disc) {
                if ($disc->title == $request->discount) {
//             Order  with discount
                    /* $applied_discount = [
                         "description" => "Custom discount",
                         "value_type" => $disc->value_type,
                         "value" => $disc->value * -1,
                         "amount" => $disc->value * -1,
                         "title" => $disc->title
                     ];*/
                    if($disc->value_type=="percentage"){
                        $d_type="PERCENTAGE";
                    }else{
                        $d_type="FIXED_AMOUNT";
                    }
                    $appliedDiscount = [
                        'description' => 'Custom discount',
                        "value" => $disc->value * -1,
                        "amount" => $disc->value * -1,
                        'valueType' => $d_type,
                        'title' => $disc->title
                    ];

//                    $draft_order["applied_discount"] = $applied_discount;
                    $data_gql["appliedDiscount"] = $appliedDiscount;
//                    return response()->json([
//                        'status' => 'log',
//                        'data_gql' => $data_gql,
//                    ],500);
                }
            }
        }



        //        Place Order on Shopify Store

        $query='mutation draftOrderCreate($input: DraftOrderInput!) {
                  draftOrderCreate(input: $input) {
                    draftOrder {
                      id
                      invoiceUrl
                      presentmentCurrencyCode
                    }
                    userErrors {
                      field
                      message
                    }
                  }
                }';
        $variables=[
            'input'=>$data_gql
        ];
        $response = Helper::apiClient()->graph($query, $variables);
       /* return response()->json([
            'status' => 'log',
            'response' => $response,
        ],200);*/

        $url = $response['body']['data']['draftOrderCreate']['draftOrder']['invoiceUrl'];

        /*$response = $this->getShopify('my-custom-led.myshopify.com')->rest('POST', '/admin/draft_orders.json',
            [
                "draft_order" => $draft_order
            ]);
                $url = $response['body']->container['draft_order']['invoice_url'];
        */
        return response()->json([
            'status' => 'success',
            'url' => $url,
        ]);
    }

}
