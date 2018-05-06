<?php
namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Requests\StoreSubscriberCreateRequest;
use App\Http\Requests\OrderCreateRequest;
use App\Http\Controllers\Controller;
use App\Http\CurrentStore;
use App\Http\Helpers;
use App\User;
use App\Store;
use App\ProductCategory;
use App\Product;
use App\ProductReview;
use App\Order;
use App\OrderItem;
use App\ShippingMethod;
use App\PaymentMode;
use App\Voucher;
use App\StoreSubscriber;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlacedManager;
use App\Mail\OrderPlacedCustomer;
use App\Mail\NewSubscriber;
use App\Mail\NewProductReview;

class StoreController extends Controller
{
	public $currentStore;
	public $storeTheme;




	public function __construct()
	{
		$currentStore = CurrentStore::store();
		$this->currentStore = $currentStore;
		$this->storeTheme = '/themes/'.$currentStore->store_theme->theme->folder_name;
	}





	public function homepage()
	{
		$store = $this->currentStore;
		$storeTheme = $this->storeTheme;
		$owner = Auth::guest() ? false : ( Auth::user()->id == $store->user->id );

		return view($this->storeTheme.'.homepage', compact('store', 'storeTheme', 'owner'));
	}





	public function productsIndex($category, Request $request)
	{

		$store = $this->currentStore;
		$storeTheme = $this->storeTheme;
		$owner = Auth::guest() ? false : ( Auth::user()->id == $store->user->id );

		if( $category == 'product' ) :
			if( isset($request->search) && !empty($request->search) ) :
				$products = $this->currentStore->products()
				->where('title', 'LIKE', '%' . $request->search . '%')
				->orderBy('created_at', 'desc')
				->paginate(16);
			else :
				$products = $this->currentStore->products()->orderBy('created_at', 'desc')->paginate(16);
			endif;
			$category = 'All Products';
		elseif( $category == 'uncategorized' ) :
			$products = $this->currentStore->products()->where('product_category_id', NULL)->orderBy('created_at', 'desc')->paginate(16);
			if( count( $products ) < 1 ) return abort('404');
			$category = 'Uncategorized';
		else :
			$productCategory = ProductCategory::where('slug', $category)->where('store_id', $store->id)->firstOrFail();
			$products = $productCategory->products()->orderBy('created_at', 'desc')->paginate(16);
			$category = $productCategory->category;
		endif;

		return view($this->storeTheme.'.products-index', compact('store', 'storeTheme', 'category', 'products', 'owner'));
	}




	public function product( $category, $slug )
	{
		$store = $this->currentStore;
		$storeTheme = $this->storeTheme;
		$owner = Auth::guest() ? false : ( Auth::user()->id == $store->user->id );

		if( $category != 'product' ) :
			$productCategory = ProductCategory::where('slug', $category )->where('store_id', $store->id)->firstOrFail();
			$product = Product::where('slug', $slug)->where('product_category_id', $productCategory->id)->firstOrFail();
		else :
			$product = Product::where('slug', $slug)->where('store_id', $store->id)->firstOrFail();
		endif;

		return view($this->storeTheme.'.product', compact('store', 'storeTheme', 'product', 'owner'));
	}





	public function cart()
	{
		$store = $this->currentStore;
		$storeTheme = $this->storeTheme;
		$owner = Auth::guest() ? false : ( Auth::user()->id == $store->user->id );
		$cart = session('cart-'.$store->id);
		if( count($cart) > 0 ) $cart = array_reverse($cart);

		return view($this->storeTheme.'.cart', compact('store', 'storeTheme', 'cart', 'owner'));
	}





	public function checkout()
	{		
		$store = $this->currentStore;
		$storeTheme = $this->storeTheme;
		$owner = Auth::guest() ? false : ( Auth::user()->id == $store->user->id );
		$cart = session('cart-'.$store->id);
		if( count($cart) > 0 ) $cart = array_reverse($cart);
		return view($this->storeTheme.'.checkout', compact('store', 'storeTheme', 'cart', 'owner'));
	}







	// POST functions


	public function add_to_cart( Request $request )
	{
		$store = $this->currentStore;
		$response = [];
		$product = Product::where('id', $request->id)->where('store_id', $store->id)->where('in_stock', true)->first();
		
    	if( $request->ajax() && $product && $product->store_id ==  $this->currentStore->id ) :
	    	$price = !empty( $product->discounted_price ) ? $product->discounted_price : $product->price;
			$cart = session('cart-'.$store->id);
	        $in_array = $this->in_array_r($request->id, $cart);

	        if( $in_array ) :
	        	foreach ( $cart as $key => &$val ) :
	                if ( $val['id'] == $request->id ) :
	                    $val['quantity']++;
	            		$total = Helpers::currencyFormat($price * $val['quantity']);
	            		$quantity = $val['quantity'];
	                    break;
	                endif;
		        endforeach;
        		session()->put('cart-'.$store->id, $cart);
	        else :
	            $cart = [
	                'id' 		=> 	$request->id,
	                'price' 	=> 	$price,
	                'quantity' 	=> 	1,
	            ];
	            $total = Helpers::currencyFormat($price);
	            $quantity = 1;
	        	session()->push('cart-'.$store->id, $cart);
	        endif;

	        $response = [
	        	'success' 			=> 	true,
	        	'product_id' 		=> 	$product->id,
	        	'quantity' 			=> 	$quantity,
	        	'total' 			=> 	$total,
	        	'cart_total_items' 	=> 	Helpers::cartTotalItems($store),
	        	'cart_total_amount' => 	Helpers::cartTotalAmount($store),
	        ];
	        return json_encode($response);
        endif;

        return abort('403');
	}




	public function subtract_from_cart( Request $request )
	{
		$store = $this->currentStore;
		$response = [];
		$product = Product::where('id', $request->id)->first();
		
    	if( $request->ajax() && $product && $product->store_id ==  $this->currentStore->id ) :
	    	$price = !empty( $product->discounted_price ) ? $product->discounted_price : $product->price;
			$cart = session('cart-'.$store->id);
	        $in_array = $this->in_array_r($request->id, $cart);

	        if( $in_array ) :
	        	foreach ( $cart as $key => &$val ) :
	                if ( $val['id'] == $request->id ) :
	                    $val['quantity']--;
	            		$total = Helpers::currencyFormat($price * $val['quantity']);
	            		$quantity = $val['quantity'];
	                    break;
	                endif;
		        endforeach;
        		session()->put('cart-'.$store->id, $cart);
	        endif;

	        $response = [
	        	'success' 			=> 	true,
	        	'message' 			=> 	'Subtracted from cart',
	        	'product_id' 		=> 	$product->id,
	        	'quantity' 			=> 	$quantity,
	        	'total' 			=> 	$total,
	        	'cart_total_items' 	=> 	Helpers::cartTotalItems($store),
	        	'cart_total_amount' => 	Helpers::cartTotalAmount($store),
	        ];
	        return json_encode($response);
        endif;

        return abort('403');
	}




	public function remove_from_cart( Request $request )
	{
		if( $request->ajax() ) :
			$store = $this->currentStore;
			$cart = session('cart-'.$store->id);
	        foreach ( $cart as $key => $val ) :
	                if ( $val['id'] == $request->input('id') ) :
	                    unset($cart[$key]);
	                endif;
	        endforeach;
	        session()->put('cart-'.$store->id, $cart);
	        
	        $response = [
	        	'success' 			=> 	true,
	        	'message' 			=> 	'Removed from cart',
	        	'cart_total_items' 	=> 	Helpers::cartTotalItems($store),
	        	'cart_total_amount' => 	Helpers::cartTotalAmount($store),
	        ];
	        return json_encode($response);
        endif;

        return abort('403');
	}




	public function checkout_store( OrderCreateRequest $request )
	{
		$store = $this->currentStore;
        $cart = session('cart-'.$store->id);

        if( count($cart) > 0 ) :
			if( Auth::guest() ) :
	            $user = User::where('email', $request->email)->first();
	            if( $user ) :
	                return redirect()->back()->withInput()->withErrors(['The email you provided is already registered. <a class="login_btn">Login here</a>']);
	            else :
	                $user = new User();
	                $user->first_name 			= $request->first_name;
	                $user->last_name 			= $request->last_name;
	                $user->email 				= $request->email;
	                $user->password 			= bcrypt($request->password);
	                $user->role 				= \Roles::Manager();
	                $user->registration_type    = 'onpage';
	                $user->street 				= $request->street;
		            $user->city 				= $request->city;
		            $user->province 			= $request->province;
		           	$user->zip 					= $request->zip;
		            $user->phone 				= $request->phone;;
	                $user->save();
	                Auth::login($user);
	            endif;
	        else :
	        	$user = Auth::user();
	        endif;

	        $voucher = false;
	        if( $request->voucher_code ) :
	        	$voucher = Voucher::where('code', $request->voucher_code)->first();
	        	$validate_voucher_code = $this->validate_voucher($request);
	       		if( isset($validate_voucher_code['error']) ) :
		        	$voucher = false;
	       		endif;
	        endif;

			$store = $this->currentStore;

			$shipping_address = [
				'first_name' => $user->first_name,
				'last_name' => $user->last_name,
				'street' => $request->street,
				'city' => $request->city,
				'province' => $request->province,
				'zip' => $request->zip,
				'phone' => $request->phone,
			];
	        $shipping_method = ShippingMethod::select('id', 'title')->where('id', $request->shipping_method)->where('store_id', $this->currentStore->id)->firstOrFail();
	        $shipping_method->rates = $shipping_method->rates;
	        $payment_mode = PaymentMode::select('id', 'title', 'description')->where('id', $request->payment_mode)->where('store_id', $this->currentStore->id)->firstOrFail();


	        $order = new Order();
	        $order->user_id = Auth::user()->id;
	        $order->store_id = $this->currentStore->id;
	        $order->shipping_address = json_encode($shipping_address);
	        $order->shipping_method = json_encode($shipping_method);
	        $order->payment_mode = json_encode($payment_mode);
	        $order->voucher = $voucher ? json_encode($voucher) : NULL;
	        $order->notes = $request->notes;
	        $order->save();


	        foreach( $cart as $item ) :
				$product = Product::select('id', 'title', 'price', 'old_price', 'weight')->where('id', ($item['id']))->where('store_id', $store->id)->where('in_stock', true)->first();
				if( $product ) :
		        	$orderItem = new OrderItem();
		        	$orderItem->order_id = $order->id;
		        	$orderItem->product_id = $product->id;
		        	$orderItem->name = $product->title;
		        	$orderItem->price = $product->price;
		        	$orderItem->old_price = $product->old_price;
		        	$orderItem->weight = $product->weight;
		        	$orderItem->quantity = $item['quantity'];
		        	$orderItem->save();
	        	endif;
			endforeach;



	        if( $request->update_address ) :
	            Auth::user()->street = $request->street;
	            Auth::user()->city = $request->city;
	            Auth::user()->province = $request->province;
	            Auth::user()->zip = $request->zip;
	            Auth::user()->phone = $request->phone;
	            Auth::user()->save();
	        endif;


	        // Check checkout_order_placed_count session
			$checkout_order_placed_count = session('checkout_order_placed_count-'.$store->id);
			if( $checkout_order_placed_count <= 20 && !$store->is_basic && $store->phone && Helpers::validPHNumber($store->phone) ) :  
	        	// Send SMS via Semaphore
	        	/*$ch = curl_init();
				$parameters = [
				    'apikey' => 'c6d0744d70af709ab0d088bf84937a44', 
				    'number' => $store->phone,
				    'message' => 'An order has been placed on your store "' . $store->name . '" by ' . Auth::user()->full_name . '.',
				    'sendername' => 'CLOUDSTORE'
				];*/
				curl_setopt( $ch, CURLOPT_URL,'http://api.semaphore.co/api/v4/messages' );
				curl_setopt( $ch, CURLOPT_POST, 1 );

				//Send the parameters set above with the request
				curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

				// Receive response from server
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
				$output = curl_exec( $ch );
				curl_close ($ch);
			

				$checkout_order_placed_count++;
		    	session()->put('checkout_order_placed_count-'.$store->id, $checkout_order_placed_count);
		    endif;

		    if( in_array(1, $store->user->email_notifications) ) :
	        	Mail::to($store->user->email)->send(new OrderPlacedManager($order));
	    	endif;

		    if( in_array(2, Auth::user()->email_notifications) ) :
	        	Mail::to(Auth::user()->email)->send(new OrderPlacedCustomer($order));
	        endif;

	        session()->forget('cart-'.$store->id);

	        return redirect( config('app.url') . '/my-account/order/' . $order->id );
	    else : 
	    	return redirect(url(''));
        endif;
	}






	public function ajax_validate_voucher( Request $request )
	{
		if( $request->ajax() && !empty($request->voucher_code) && !empty($request->email) ) :
	        return json_encode($this->validate_voucher($request));
		endif;

        return abort('403');
	}



	public function validate_voucher( $request )
	{
		$voucher = Voucher::where('code', $request->voucher_code)->where('store_id', $this->currentStore->id)->first();
		if( $voucher ) :
			$hasUsedInOrder = false;

			// Check if already used by user
			$user = User::where('email', $request->email)->first();
			if( $user ) :
				$usedInOrder = $user->orders->filter(function($value, $key) use ($voucher){
					return $value->voucher && $value->voucher->code == $voucher->code;
				});
				if( $usedInOrder->count() > 0 ) :
					$response = [
			        	'error' 	=> 	true,
			        	'message' 	=> 	'You already used this voucher code.',
			        ];
			        $hasUsedInOrder = true;
				endif;
			endif;

    		if( !$hasUsedInOrder && strtotime(date('Y-m-d')) > strtotime($voucher->valid_until) ): 
				$response = [
		        	'error' 	=> 	true,
		        	'message' 	=> 	'Voucher code is expired.',
		        ];
		    elseif( !$hasUsedInOrder && strtotime(date('Y-m-d')) < strtotime($voucher->valid_until) ): 
				$response = [
		        	'success' 			=> 	true,
		        	'discount' 			=>	$voucher->discount,
		        	'discount_format' 	=>	'- '.Helpers::currencyFormat($voucher->discount),
		        ];
	        endif;

		else :
			$response = [
	        	'error' 	=> 	true,
	        	'message' 	=> 	'Invalid voucher code.',
	        ];

		endif;
        return $response;
	}



	public function in_array_r( $needle, $haystack ) 
    {
        if ( !empty($haystack) ):
	        foreach ( $haystack as $item ) :
	            if ( $item['id'] == $needle ) return true;
	        endforeach;
        endif;

        return false;
    }




    public function subscribe( StoreSubscriberCreateRequest $request )
    {
    	$exists = StoreSubscriber::where('store_id', $this->currentStore->id)->where('email', $request->email)->first();
    	$store = $this->currentStore;

    	if( !$store->is_basic ) :
	    	if( !$exists ) :
	    		$storeSubscriber = new StoreSubscriber();
	    		$storeSubscriber->store_id = $store->id;
	    		$storeSubscriber->full_name = $request->full_name;
	    		$storeSubscriber->email = $request->email;
	    		$storeSubscriber->save();

			    if( in_array(3, $store->user->email_notifications) ) :
		        	Mail::to($store->user->email)->send(new NewSubscriber($storeSubscriber));
		    	endif;
	    	endif;
	    	return redirect()->back()->with('subscribe_success', []);
    	else :
    		return abort('403');
    	endif;
    }



    public function review( Request $request )
    {
    	if( Auth::guest() ) :
    		return redirect()->back();
    	endif;

		$store = $this->currentStore;
		$product = Product::where('id', $request->product_id)->where('store_id', $store->id)->first();
		if( $product ) :
			$exists = ProductReview::where('product_id', $request->product_id)->where('user_id', Auth::user()->id)->first();
			if( !$exists ) :
				$product_review = new ProductReview();
				$product_review->product_id = $request->product_id;
				$product_review->user_id = Auth::user()->id;
				$product_review->rating = $request->rating;
				$product_review->comment = $request->comment;
				$product_review->save();
			    if( in_array(4, $store->user->email_notifications) ) :
		        	Mail::to($store->user->email)->send(new NewProductReview($product_review));
		    	endif;
			endif;
			return redirect()->back();
		else :
			return abort('403');
		endif;
    }


}
