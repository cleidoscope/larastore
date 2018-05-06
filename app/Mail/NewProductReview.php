<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\ProductReview;
use App\User;

class NewProductReview extends Mailable
{
    use Queueable, SerializesModels;

    public $actionUrl;
    public $actionText = "Manage product reviews";
    public $productReview;
    
    public function __construct(ProductReview $productReview)
    {
        $this->productReview = $productReview;
        $this->actionUrl = route('manager.review.index', $productReview->product->store->id);
    }

    public function build()
    {
        return $this->from('support@cloudstore.ph', 'Cloudstore Philippines')
                ->subject("New product review for ".$this->productReview->product->title)
                ->view('emails.new_product_review');
    }
}
