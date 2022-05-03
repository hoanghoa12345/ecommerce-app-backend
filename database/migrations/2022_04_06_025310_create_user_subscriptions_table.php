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
            $table->foreignIdFor(User::class)->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignIdFor(Subscription::class)->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('payment_status')->nullable();
            $table->time('delivery_schedule')->nullable();
//            $table->foreignIdFor(SubscriptionDelivery::class);
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
//        Schema::disableForeignKeyConstraints();
//        Schema::table('user_subscriptions', function (Blueprint $table) {
//            $table->dropForeign(['subscription_id']);
//            $table->dropColumn('subscription_id');
//            $table->dropForeign(['user_id']);
//            $table->dropColumn('user_id');
//        });
//        ALTER TABLE `user_subscriptions` DROP INDEX `user_subscriptions_user_id_foreign`;
        Schema::dropIfExists('user_subscriptions');
    }
}
