<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->default(0);
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('client_id')->nullable()->default('logezy');
            $table->string('api_token')->nullable()->default('PL8JtlGm6qNiyxaCdSdgtKbq4YR5C2cACjRkwmCfhdsDFxB8K5Ku9cfAXBCI');
            $table->boolean('is_white_label')->default(0);
            $table->string('db_name')->nullable();
            $table->string('db_username')->nullable();
            $table->string('db_password')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->text('details')->nullable();
            $table->boolean('is_active')->default(1);
            $table->text('logo')->nullable();
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
        Schema::dropIfExists('tenants');
    }
}