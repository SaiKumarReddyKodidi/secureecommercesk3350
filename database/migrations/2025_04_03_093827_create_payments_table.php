<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');  // The user who made the payment
            $table->string('product_id');  // Product ID(s), can be stored as a JSON or serialized string
            $table->string('name');  // Product name
            $table->decimal('price', 8, 2);  // Product price
            $table->integer('quantity');  // Product quantity
            $table->decimal('total', 8, 2);  // Total for the product
            $table->enum('purchase_status', ['success', 'failed'])->default('failed');  // Purchase status
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}

