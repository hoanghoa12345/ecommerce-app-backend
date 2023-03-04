<?php

namespace App\Mail;

use App\Models\Profile;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class SubscribeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $profile;
    public $userSubscription;
    public $subscription;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Profile $profile, UserSubscription $userSubscription, Subscription $subscription)
    {
        $this->user = $user;
        $this->profile = $profile;
        $this->userSubscription = $userSubscription;
        $this->subscription = $subscription;
    }

    /**
     * Build the message with subject.
     *
     * @return $this
     */
    public function build()
    {
        $app_name = Config::get('app.name', 'Eclean Store');
        return $this->subject($app_name . " - Thông tin đăng ký gói sản phẩm")->view('emails.subscribe');
    }
}
