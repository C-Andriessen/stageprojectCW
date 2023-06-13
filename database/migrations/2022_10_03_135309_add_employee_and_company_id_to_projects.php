<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmployeeAndCompanyIdToProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table)
        {
            $table->foreignId('company_id')->after('end_date')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('employee_id')->after('end_date')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table)
        {
            $table->dropForeign(['company_id', 'employee_id']);
            $table->dropColumn('company_id');
            $table->dropColumn('employee_id');
        });
    }
}
