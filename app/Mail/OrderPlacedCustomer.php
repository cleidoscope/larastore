<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Order;
use App\User;

class OrderPlacedCustomer extends Mailable
{
    use Queueable, SerializesModels;

    public $actionUrl;
    public $actionText = "View Order";
    public $order;
    public $user;
    
    public function __construct(Order $order)
    {
        $this->user = User::find(4);
        $this->order = $order;
        $this->actionUrl = route('manager.order.show', $order->id);
    }

    public function build()
    {
        return $this->from('support@cloudstore.ph', 'Cloudstore Philippines')
                ->subject("You've placed an order in ".$this->order->store->name)
                ->view('emails.order_placed_customer');
    }
}
