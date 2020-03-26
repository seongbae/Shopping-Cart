<?php

namespace App\Modules\Cart\Mail;

use App\Modules\Cart\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ItemPurchased extends Mailable
{
    use Queueable, SerializesModels;

    private $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(option('from_email'), option('from_name'))
                ->subject('Your order #'.$this->order->order_number)
                ->markdown('emails.item.purchased')
                ->with('order', $this->order);
    }
}
