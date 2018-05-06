<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Order;

class OrderPlacedManager extends Mailable
{
    use Queueable, SerializesModels;

    public $actionUrl;
    public $actionText = "View Order";
    public $order;
    
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->actionUrl = route('manager.store-order.show', ['store_id' => $order->store->id, 'id' => $order->id]);
    }

    public function build()
    {
        return $this->from('support@cloudstore.ph', 'Cloudstore Philippines')
                ->subject('New order from your store '.$this->order->store->name)
                ->view('emails.order_placed_manager');
    }
}
