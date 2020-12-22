<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('invoice_id')->unsigned();
            $table->string('referense', 128);
            $table->text('commets')->nullable();
            $table->bigInteger('payment_method_id')->unsigned()->default(1);
            $table->decimal('total', 8, 2)->nullable();
            $table->string('file', 128)->nullable();
            $table->bigInteger('banck_account_id')->unsigned();
            $table->date('operationed_at')->nullable();
            $table->timestamps();

            $table->foreign('invoice_id')
                ->references('id')->on('invoices')
                ->onDelete('cascade');

            $table->foreign('banck_account_id')
                ->references('id')->on('banck_accounts');

            $table->foreign('payment_method_id')
                ->references('id')->on('payment_methods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vouchers');
    }
}
