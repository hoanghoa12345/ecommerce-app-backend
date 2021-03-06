<?php

use App\Models\Subscription;
use App\Models\UserSubscription;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionUserSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('subscriptions_user_subscriptions'))
        Schema::create('subscriptions_user_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Subscription::class)->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');;
            $table->foreignIdFor(UserSubscription::class)->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');;
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
        Schema::dropIfExists('subscription_user_subscription');
    }
}
