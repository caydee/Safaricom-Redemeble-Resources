<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
            {
                Schema::create('users', function (Blueprint $table) {
                    $table->id();
                    $table->string('name');
                    $table->string('email')->unique();
                    $table->string('google_id')->nullable();
                    $table->string('facebook_id')->nullable();
                    $table->string('twitter_id')->nullable();
                    $table->unsignedBigInteger('organization_id');
                    $table->integer('status')->default(0);
                    $table->timestamp('email_verified_at')->nullable();
                    $table->string('password');
                    $table->string('phone_no');
                    $table->rememberToken();
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
                Schema::dropIfExists('users');
            }
    }
