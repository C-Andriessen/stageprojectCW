<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table)
        {
            $table->integer('status')->after('total_amount');
            $table->float('subtotal_excl')->after('customer_city');
            $table->float('vat_total')->after('subtotal_excl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table)
        {
            $table->dropColumn('status');
            $table->dropColumn('subtotal_excl');
            $table->dropColumn('vat_total');
        });
    }
}
