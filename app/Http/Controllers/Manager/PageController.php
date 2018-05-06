<?php
namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Plan;
use App\Invoice;
use App\Transaction;
require '../app/Http/PaypalIPN/PaypalIPN.php';
use PaypalIPN;
use Carbon\Carbon;
use App\Store;


class PageController extends Controller
{
   
    public function homepage()
    {
    	return view('manager.homepage');
    }




    public function pricing()
    {
    	$plans = Plan::orderBy('price', 'asc')->get();
    	return view('manager.pricing', compact('plans'));
    }




    public function support()
    {
        return view('manager.support');
    }




    public function contact()
    {
        return view('manager.contact');
    }




    public function subscribed()
    {
        return view('manager.subscribed');
    }




    public function privacy_policy()
    {
        return view('manager.privacy-policy');
    }




    public function about()
    {
        return view('manager.about');
    }




    public function paypal_ipn( Request $request )
    {
        $ipn = new PaypalIPN();

        //$ipn->useSandbox();

        $verified = $ipn->verifyIPN();

        if ($verified) :
            $invoice = Invoice::find($request->item_number);
            if( $invoice ) :
                $transaction = new Transaction();
                $transaction->invoice_id = $invoice->id;
                $transaction->amount = $request->mc_gross;
                $transaction->mode = 'Paypal';
                $transaction->mode_transaction = $request->txn_id;
                $transaction->save();

                if( $invoice->store ) :
                    $transactions_sum = $invoice->transactions()->sum('amount');
                    if( $invoice->amount -  $transactions_sum <= 0 ) :
                        $invoice->store->is_active = 1;
                        $invoice->store->save();
                    endif;
                endif;
            endif;

            //mail('cleidoscope@gmail.com', 'Verified', json_encode($request->all()));
        endif;

        return header("HTTP/1.1 200 OK");
    }


}
