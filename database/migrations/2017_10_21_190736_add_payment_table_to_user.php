<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentTableToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('stripe_subscription_id')->nullable();
            $table->enum('billing_type', ['stripe', 'paypal'])->nullable();
            $table->boolean('active_subscription')->nullable();
            $table->timestamp('subscription_end_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('stripe_subscription_id');
            $table->dropColumn('billing_type');
            $table->dropColumn('active_subscription');
            $table->dropColumn('subscription_end_at');
        });
    }
}
