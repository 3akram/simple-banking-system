<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('currency_type');
        });
        DB::table('currencies')->insert([
            ['currency_type' => 'EGP'],
            ['currency_type' => 'EURO'],
            ['currency_type' => 'USD'],
            ['currency_type' => 'SAR'],
            ['currency_type' => 'JPY'],
            ['currency_type' => 'CHF'],
            ['currency_type' => 'CAD'],
            ['currency_type' => 'ZAR'],

        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');
    }
}
