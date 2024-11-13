<?php

use App\Models\Notification;
use Carbon\Carbon;
use Osiset\BasicShopifyAPI\BasicShopifyAPI;
use Osiset\BasicShopifyAPI\Options;
use Osiset\BasicShopifyAPI\Session;


// app/Helpers/Helper.php
if (!function_exists('getShopify')) {
    function getShopify()
    {
        $setting = \App\Models\ShopifySetting::first();
        if (!empty($setting)) {
            $options = new \Gnikyt\BasicShopifyAPI\Options();
            $options->setType(true);
            $options->setVersion($setting->api_version);
            $options->setApiKey($setting->api_key);
            $options->setApiSecret($setting->api_secret);
            $options->setApiPassword($setting->api_token);

            $api = new \Gnikyt\BasicShopifyAPI\BasicShopifyAPI($options);
            $api->setSession(new \Gnikyt\BasicShopifyAPI\Session($setting->shop_domain));

            return $api;
        } else {
            return response()->json([
                'status' => false,
                'message' => 'No Settings Found Or Your Settings Are Inactive!',
            ]);
        }
    }
}

