<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopifySettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopify_settings', function (Blueprint $table) {
            $table->id();
            $table->longText('api_key')->nullable();
            $table->longText('api_secret')->nullable();
            $table->longText('api_token')->nullable();
            $table->longText('shop_domain')->nullable();
            $table->string('api_version')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shopify_settings');
    }
}
