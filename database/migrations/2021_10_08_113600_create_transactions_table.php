<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
            {
                Schema::create('transactions', function (Blueprint $table) {
                    $table->id();
                    $table->string('receipt_no')->unique();
                    $table->double('amount',8,2);
                    $table->double('amount_paid')->nullable();
                    $table->double('rate',4.2)->nullable();
                    $table->bigInteger('units')->default(0);
                    $table->tinyInteger("status")->default(0);
                    $table->enum('channel',['mpesa','cheque','cash','paypal']);
                    $table->unsignedBigInteger('product_id');
                    $table->unsignedBigInteger('organization_id');
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
                Schema::dropIfExists('transactions');
            }
    }
