<?php

use App\Models\Subscription;
use App\Models\SubscriptionDelivery;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Subscription::class)->constrained();
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('payment_status')->nullable();
            $table->dateTime('delivery_schedule')->nullable();
            $table->foreignIdFor(SubscriptionDelivery::class);
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
        Schema::dropIfExists('user_subcriptions');
    }
}
