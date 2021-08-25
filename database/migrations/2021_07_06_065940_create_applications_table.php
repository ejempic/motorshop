<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->integer('unit_id');
            $table->string('application_number');
            $table->double('total_price');
            $table->double('down_payment');
            $table->integer('terms');
            $table->double('rebate');
            $table->double('amortization');
            $table->double('first_payment_due');
            $table->double('gross_monthly_rate');
            $table->double('net_monthly_rate');
            $table->date('start_date');
            $table->date('end_date');
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
        Schema::dropIfExists('applications');
    }
}
