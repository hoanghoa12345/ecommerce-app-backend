<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderDetailMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $order;
    public $order_list;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $order, $order_list)
    {
        $this->user = $user;
        $this->order = $order;
        $this->order_list = $order_list;
    }

    /**
     * Build the message with subject.
     *
     * @return $this
     */
    public function build()
    {
        $app_name = env('APP_NAME', 'Eclean Store');
        return $this->subject($app_name . " - Thông tin đơn hàng")->view('emails.orders');
    }
}
