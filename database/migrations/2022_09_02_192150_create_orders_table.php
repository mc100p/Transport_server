<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('delivery_status');
            $table->string('order_status');
            $table->string('package_delivery_photo')->nullable();
            $table->string('delivery_personnel')->nullable();
            $table->string('customer_id');
            $table->string('customer_email');
            $table->string('customer_name');
            $table->string('customer_address');
            $table->string('customer_parish');
            $table->string('customer_phone_number');
            $table->string('package_location');
            $table->string('package_street_address');
            $table->string('package_parish_address');
            $table->string('delivery_instructions')->nullable();
            $table->string('fragility');
            $table->string('item_name');
            $table->string('item_payment_status');
            $table->decimal('item_height');
            $table->decimal('item_width');
            $table->decimal('item_weight')->nullable();
            $table->string('item_description')->nullable();
            $table->string('ideal_vehicle');
            $table->string('estimated_delivery_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
