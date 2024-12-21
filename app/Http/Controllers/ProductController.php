<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Osiset\BasicShopifyAPI\BasicShopifyAPI;
use Osiset\BasicShopifyAPI\Options;
use Osiset\BasicShopifyAPI\Session;

class ProductController extends Controller
{
    public function ShopifyProducts($next = null)
    {
        $shop = Auth::user();
        $api=getShopify();
        $products = $api->rest('GET', '/admin/products.json', [
            'limit' => 250,
            'page_info' => $next
        ]);

        $products = json_decode(json_encode($products));


        foreach ($products->body->products as $product) {

            $this->createShopifyProducts($product, $shop);
        }
        if (isset($products->link->next)) {
            $this->ShopifyProducts($products->link->next);
        }

        return redirect()->back()->with('message', 'Products Synced Successfully');
//        return Redirect::tokenRedirect('all.products', ['notice' => 'Products Synced Successfully']);
    }


    public function product_create_webhook(Request  $request){
        $productData = $request->all();
        $product = json_decode(json_encode($productData), false);
        $shop=User::first();
        $this->createShopifyProducts($product,$shop);
        return response()->json(['success' => true]);
    }

    public function createShopifyProducts($product, $shop)
    {
        $p = Product::where('shopify_id', $product->id)->where('shop_id',$shop->id)->first();
        if ($p === null) {
            $p = new Product();
        }
        if ($product->images) {
            $image = $product->images[0]->src;
        } else {
            $image = '';
        }
        $p->shopify_id = $product->id;
        $p->title = $product->title;
        $p->description = $product->body_html;
        $p->handle = $product->handle;
        $p->vendor = $product->vendor;
        $p->type = $product->product_type;
        $p->featured_image = $image;
        $p->tags = $product->tags;
        $p->options = json_encode($product->options);
        $p->status = $product->status;
        $p->published_at = $product->published_at;
        $p->shop_id = $shop->id;
        $p->save();
        if (count($product->variants) >= 1) {
            foreach ($product->variants as $variant) {
                $v = ProductVariant::where('shopify_id', $variant->id)->where('shop_id',$shop->id)->first();
                if ($v === null) {
                    $v = new ProductVariant();
                }
                $v->shopify_id = $variant->id;
                $v->shopify_product_id = $variant->product_id;
                $v->title = $variant->title;
                $v->option1 = $variant->option1;
                $v->option2 = $variant->option2;
                $v->option3 = $variant->option2;
                $v->sku = $variant->sku;
                $v->requires_shipping = $variant->requires_shipping;
                $v->fulfillment_service = $variant->fulfillment_service;
                $v->taxable = $variant->taxable;
                if (isset($product->images)){
                    foreach ($product->images as $image){
                        if (isset($variant->image_id)){
                            if ($image->id == $variant->image_id){
                                $v->image = $image->src;
                            }
                        }else{
                            $v->image = "";
                        }
                    }
                }
                $v->price = $variant->price;
                $v->compare_at_price = $variant->compare_at_price;
                $v->weight = $variant->weight;
                $v->grams = $variant->grams;
                $v->weight_unit = $variant->weight_unit;
                $v->inventory_item_id = $variant->inventory_item_id;
                $v->shop_id = $shop->id;
                $v->save();
            }
        }
    }


    public function product_delete_webhook(Request $request){

        $productData = $request->all();
        $product = json_decode(json_encode($productData), false);
        $dellproduct = Product::where('shopify_id',$product->id)->first();
        $product_id = $product->id;
        $productvarients = ProductVariant::where('shopify_product_id',$product_id)->get();
        foreach ($productvarients as $varient){
            $varient->delete();
        }
        $dellproduct->delete();
    }
}
