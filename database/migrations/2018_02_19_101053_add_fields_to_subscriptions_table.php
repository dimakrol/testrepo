<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $platform = Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('enum', 'string');

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->string('braintree_id')->nullable();
            $table->string('braintree_plan')->nullable();
            $table->string('stripe_id')->nullable()->change();
            $table->string('stripe_plan')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $platform = Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('enum', 'string');

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn('braintree_id');
            $table->dropColumn('braintree_plan');
            $table->string('stripe_id')->change();

        });
    }
}
