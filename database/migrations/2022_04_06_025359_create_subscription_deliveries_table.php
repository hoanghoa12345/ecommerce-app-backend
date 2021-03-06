<?php

use App\Models\UserSubscription;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('subscription_deliveries'))
        Schema::create('subscription_deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(UserSubscription::class)->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');;
            $table->dateTime('delivery_at')->nullable();
            $table->enum('status',['success','failed', 'pending'])->default('pending');
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
        Schema::dropIfExists('subscription_deliveries');
    }
}
