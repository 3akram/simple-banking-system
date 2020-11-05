<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddAccountTypeToAccountTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('account_types', function (Blueprint $table) {
            $table->string('account_type');
        });

        DB::table('account_types')->insert([
            ['account_type' => 'Current Account'],
            ['account_type' => 'Saving Account' ],
            ['account_type' => 'Credit Account' ],
            ['account_type' => 'Joint Account'  ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('account_types', function (Blueprint $table) {
            $table->dropColumn('account_type');
        });
    }
}
