<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('shop.logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [\App\Http\Controllers\admin\AdminController::class, 'index'])->name('home');

    //orders
    Route::get('/orders', [\App\Http\Controllers\admin\OrderController::class, 'orders'])->name('orders');
    Route::post('orders-filter', [\App\Http\Controllers\admin\OrderController::class, 'OrdersFilter'])->name('orders.filter');
    Route::get('order-view/{id}', [\App\Http\Controllers\admin\OrderController::class, 'OrderView'])->name('order.view');
    Route::get('sync/orders', [\App\Http\Controllers\admin\OrderController::class, 'shopifyOrders'])->name('sync_orders');

    //products
    Route::get('sync/products', [App\Http\Controllers\ProductController::class, 'ShopifyProducts'])->name('sync_products');


    //sessions
    Route::get('/sessions', [\App\Http\Controllers\admin\SessionController::class, 'index'])->name('sessions');
    Route::get('/create/session', [\App\Http\Controllers\admin\SessionController::class, 'CreateSession'])->name('create_session');
    Route::post('/save/session', [\App\Http\Controllers\admin\SessionController::class, 'SaveSession'])->name('save_session');
    Route::get('/view/session/{id}', [\App\Http\Controllers\admin\SessionController::class, 'ViewSession'])->name('view_session');
    Route::get('/delete/session/{id}', [\App\Http\Controllers\admin\SessionController::class, 'DeleteSession'])->name('delete_session');
    Route::post('/update-session-status/{id}', [\App\Http\Controllers\admin\SessionController::class, 'updateStatus'])->name('update.session.status');
    Route::post('/session/detail/update/{id}', [\App\Http\Controllers\admin\SessionController::class, 'SessionDetailUpdate'])->name('session.detail.update');




    Route::post('/save/package', [\App\Http\Controllers\admin\PackageController::class, 'SavePackage'])->name('save_package');
    Route::post('/update/package/{id}', [\App\Http\Controllers\admin\PackageController::class, 'UpdatePackage'])->name('update_package');
    Route::get('/delete/package/{id}', [\App\Http\Controllers\admin\PackageController::class, 'DeletePackage'])->name('delete_package');
});
Auth::routes();


Route::get('/createWebhook', function() {
    dd(1);
    $shop = \Illuminate\Support\Facades\Auth::user();
    $webhooks = [
        [
            "webhook" => [
                'topic' => 'products/create',
                "format" => "json",
                "address" => "https://phpstack-1200320-4238599.cloudwaysapps.com/webhook/product-create"
            ]
        ],
        [
            "webhook" => [
                'topic' => 'products/update',
                "format" => "json",
                "address" => "https://phpstack-1200320-4238599.cloudwaysapps.com/webhook/product-update"
            ]
        ],
        [
            "webhook" => [
                'topic' => 'orders/updated',
                "format" => "json",
                "address" => "https://phpstack-1200320-4238599.cloudwaysapps.com/webhook/orders-updated"
            ]
        ],
        [
            "webhook" => [
                'topic' => 'orders/create',
                "format" => "json",
                "address" => "https://phpstack-1200320-4238599.cloudwaysapps.com/webhook/orders-create"
            ]
        ]
    ];

    foreach ($webhooks as $webhook) {
        $orders = $shop->api()->rest('POST', '/admin/api/2023-10/webhooks.json', $webhook);
    }
    dd($orders);
});




Route::middleware(['auth.shopify'])->group(function() {
    Route::get('/getWebhook', function() {


        $shop = \Illuminate\Support\Facades\Auth::user();
        $response = $shop->api()->rest('GET', '/admin/webhooks.json');
        dd($response);
    });
    Route::get('/deleteWebhook', function() {
        dd(1);
        $shop = \Illuminate\Support\Facades\Auth::user();
        $response = $shop->api()->rest('GET', '/admin/webhooks.json');
        $response=json_decode(json_encode($response),false);
        foreach ($response->body->webhooks as $wHook){
            $response = $shop->api()->rest('delete', '/admin/webhooks/'.$wHook->id.'.json');
        }
        dd($response);
    });
    Route::get('/createWebhook', function() {
        dd(1);
        $shop = \Illuminate\Support\Facades\Auth::user();
        $webhooks = [
            [
                "webhook" => [
                    'topic' => 'products/create',
                    "format" => "json",
                    "address" => "https://phpstack-1200320-4238599.cloudwaysapps.com/webhook/product-create"
                ]
            ],
            [
                "webhook" => [
                    'topic' => 'products/update',
                    "format" => "json",
                    "address" => "https://phpstack-1200320-4238599.cloudwaysapps.com/webhook/product-update"
                ]
            ],
            [
                "webhook" => [
                    'topic' => 'orders/updated',
                    "format" => "json",
                    "address" => "https://phpstack-1200320-4238599.cloudwaysapps.com/webhook/orders-updated"
                ]
            ],
            [
                "webhook" => [
                    'topic' => 'orders/create',
                    "format" => "json",
                    "address" => "https://phpstack-1200320-4238599.cloudwaysapps.com/webhook/orders-create"
                ]
            ]
        ];

        foreach ($webhooks as $webhook) {
            $orders = $shop->api()->rest('POST', '/admin/api/2023-10/webhooks.json', $webhook);
        }
        dd($orders);
    });

//    Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('home');
    Route::get('/products', [\App\Http\Controllers\admin\AdminController::class, 'products'])->name('products');
    Route::get('/product/{id}/view', [\App\Http\Controllers\admin\AdminController::class, 'product_view'])->name('product.view');
    Route::post('/product/update/{id}', [\App\Http\Controllers\admin\AdminController::class, 'product_update'])->name('product.update');
    Route::post('/product/update_all', [\App\Http\Controllers\admin\AdminController::class, 'product_update_all'])->name('product.update_all');
    Route::get('/sync/product', [App\Http\Controllers\ProductController::class, 'SyncProducts'])->name('sync_product');
//    Route::get('/sync/orders', [App\Http\Controllers\AdminController::class, 'SyncOrders'])->name('sync_product');


    Route::get('test', function() {
//        $product=\App\Models\Product::with('has_variant')->where('shopify_id',7593957327048)->first();
//       $inventory_item_id= $product->has_variant[0]->inventory_item_id;
       $inventory_item_id=44955442774216;
        $inventory_item_id="gid://shopify/InventoryItem/".$inventory_item_id;
        $query = 'query {
  inventoryItem(id: "'.$inventory_item_id.'") {
    id
    tracked
    sku
    inventoryLevels(first: 1) {
      nodes {
        location {
          id
          name
        }
        quantities(names:["incoming"]){name quantity updatedAt}
        updatedAt
      }
    }
  }
}';

        $responce = \App\Helpers\Helper::apiClient()->graph($query);
        $responce=json_decode(json_encode($responce),false);
        if(!$responce->errors){
            $incomingInventory=$responce->body->data->inventoryItem->inventoryLevels->nodes[0]->quantities[0];
            $new_quantity=$incomingInventory->quantity;
        }
        dd($responce);
    });
});
