<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Lineitem;
use App\Models\Order;
use App\Models\OrderLineItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function getShopify;
use function view;

class OrderController extends Controller
{
    public function Orders(){
        $orders=Order::orderBy('order_number','desc')->paginate(10);
        return view('admin.orders.index',compact('orders'));
    }

    public function OrdersFilter(Request $request){
        $shop=Auth::user();
        $orders=Order::query();
        if($request->orders_filter){
            $orders = $orders->where('order_number', 'like', '%' . $request->orders_filter . '%')->orWhere('shipping_name', 'like', '%' . $request->orders_filter . '%');
        }
        $orders=$orders->paginate(10);
        return view('admin.orders.index',compact('request','orders'));
    }

    public function OrderView($id){
        $order = Order::where('id',$id)->first();

        $shop=Auth::user();
        $line_items_count=OrderLineItem::where('order_id',$id)->where('shop_id',$shop->id)->count();
        return view('admin.orders.order-detail')->with([
            'order'=>$order,
            'line_items_count'=>$line_items_count

        ]);
    }


    public function shopifyOrders($next = null){

        $shop=Auth::user();

        $api=getShopify();
        $orders = $api->rest('GET', '/admin/api/orders.json', [
            'limit' => 250,
            'page_info' => $next,
            'status'=>'any'
        ]);

        if ($orders['errors'] == false) {
            if (count($orders['body']->container['orders']) > 0) {
                foreach ($orders['body']->container['orders'] as $order) {
                    $order = json_decode(json_encode($order));
                    $this->singleOrder($order,$shop);
                }
            }
        }
        if (isset($orders['link']['next'])) {

            $this->shopifyOrders($orders['link']['next']);
        }
//        return redirect()->back()->with('message', 'Orders Synced Successfully');

    }


    public function order_create_webhook(Request $request)
    {
        $orderData = $request->all();
        $order = json_decode(json_encode($orderData), false);
        $this->singleOrder($order);
        return response()->json(['success' => true]);
    }



    public function createWebhooks(Request $request)
    {
       $api=getShopify();


        $data = [
            "webhook" => [
                "topic" => "orders/updated",
                "address" => "https://phpstack-1365877-5032283.cloudwaysapps.com/webhook/order/update",
                "format" => "json",
            ]
        ];
        $response = $api->rest('POST', '/admin/webhooks.json', $data,[], true);
        dd($response);

        $data = [
            "webhook" => [
                "topic" => "orders/create",
                "address" => "https://phpstack-1365877-5032283.cloudwaysapps.com/webhook/order/create",
                "format" => "json",
            ]
        ];
        $response = $api->rest('POST', '/admin/webhooks.json', $data,[], true);
        dd($response);



    }

    public function singleOrder($order)
    {

        $shop=User::first();
        if($order->financial_status!='refunded' && $order->cancelled_at==null  ) {

            $newOrder = Order::where('shopify_id', $order->id)->first();
            if ($newOrder == null) {
                $newOrder = new Order();
            }
            $newOrder->shopify_id = $order->id;
            $newOrder->email = $order->email;
            $newOrder->order_number = $order->name;
            if (isset($order->shipping_address)) {
                $newOrder->shipping_name = $order->shipping_address->name;
                $newOrder->address1 = $order->shipping_address->address1;
                $newOrder->address2 = $order->shipping_address->address2;
                $newOrder->phone = $order->shipping_address->phone;
                $newOrder->city = $order->shipping_address->city;
                $newOrder->zip = $order->shipping_address->zip;
                $newOrder->province = $order->shipping_address->province;
                $newOrder->country = $order->shipping_address->country;
            }
            $newOrder->financial_status = $order->financial_status;
            $newOrder->fulfillment_status = $order->fulfillment_status;
            if (isset($order->customer)) {
                $newOrder->first_name = $order->customer->first_name;
                $newOrder->last_name = $order->customer->last_name;
                $newOrder->customer_phone = $order->customer->phone;
                $newOrder->customer_email = $order->customer->email;
                $newOrder->customer_id = $order->customer->id;
            }
            $newOrder->shopify_created_at = date_create($order->created_at)->format('Y-m-d h:i:s');
            $newOrder->shopify_updated_at = date_create($order->updated_at)->format('Y-m-d h:i:s');
            $newOrder->tags = $order->tags;
            $newOrder->note = $order->note;
            $newOrder->total_price = $order->total_price;
            $newOrder->currency = $order->currency;

            $newOrder->subtotal_price = $order->subtotal_price;
            $newOrder->total_weight = $order->total_weight;
            $newOrder->taxes_included = $order->taxes_included;
            $newOrder->total_tax = $order->total_tax;
            $newOrder->currency = $order->currency;
            $newOrder->total_discounts = $order->total_discounts;
            $newOrder->shop_id = $shop->id;
            $newOrder->save();


            foreach ($order->line_items as $item) {

                $new_line = OrderLineItem::where('lineitem_id', $item->id)->where('order_id', $newOrder->id)->where('shop_id', $shop->id)->first();
                if ($new_line == null) {
                    $new_line = new OrderLineItem();
                }
                $new_line->shopify_product_id = $item->product_id;
                $new_line->shopify_variant_id = $item->variant_id;
                $new_line->lineitem_id=$item->id;
                $new_line->title = $item->title;
                $new_line->quantity = $item->quantity;
                $new_line->sku = $item->sku;
                $new_line->variant_title = $item->variant_title;
                $new_line->title = $item->title;
                $new_line->vendor = $item->vendor;
                $new_line->price = $item->price;
                $new_line->requires_shipping = $item->requires_shipping;
                $new_line->taxable = $item->taxable;
                $new_line->name = $item->name;
                $new_line->properties = json_encode($item->properties, true);
                $new_line->fulfillable_quantity = $item->fulfillable_quantity;
                $new_line->fulfillment_status = $item->fulfillment_status;
                $new_line->order_id = $newOrder->id;
                $new_line->shop_id = $shop->id;
                $new_line->shopify_order_id = $order->id;
                $new_line->save();
            }
        }
    }

}
