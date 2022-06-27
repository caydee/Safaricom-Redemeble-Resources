<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
        {
            Schema::create('sms', function (Blueprint $table) {
                        $table->id();
                        $table->string('msisdn');
                        $table->text('message');
                        $table->text('link_id')->nullable();
                        $table->text('offercode');
                        $table->string('type')->nullable();
                        $table->text('referenceid');
                        $table->tinyInteger('processed')->default(0);
                        $table->text('client_transaction_id');
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
            Schema::dropIfExists('sms');
        }
}
