<?php
namespace App\Http;

use App\Http\CurrentStore;
use File;
use Carbon\Carbon;

class Helpers
{
	public static function currencyFormat($value)
	{
		return config('app.currency') . number_format($value, 2);
	}




	public static function getImage($url)
	{
		if( empty($url) || !File::exists(substr($url, 1)) )  return url('/images/placeholder.jpg');
		return $url;
	}


	public static function storeLogo($url, $size = false)
	{
		if( !empty($url) ) : 
			$file = $url;
			if( $size ) :
				$dir = pathinfo($file, PATHINFO_DIRNAME);
				$name = pathinfo($file, PATHINFO_FILENAME);
				$ext = pathinfo($file, PATHINFO_EXTENSION);
				$file = $dir . '/' . $name . '-' . $size . '.' . $ext;
			endif;
			if( File::exists(substr($file, 1)) ) :
				return $file;
			endif;
			return url('/images/placeholder.jpg');
		endif;

		return url('/images/placeholder.jpg');
	}



	public static function curl($url)
	{
		$ch = curl_init($url); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$data = curl_exec($ch);
		return $data;
	}




	public static function isJson($string) 
	{
		json_decode($string);
		return json_last_error() === 0;
	}




	public static function getSubdomain($string)
	{
		$domain = parse_url($string, PHP_URL_HOST);
       	$string = explode('.', $domain);
       	if( count( $string ) == 3 ) :
       		$domain = reset($string);
       	endif;

       	return $domain;
	}





	public static function getDiscountHTML($price, $old_price)
	{
		if( !empty($price) && !empty($old_price) ) :
			$html = '';
			$discount = 100 - ($price / $old_price) * 100 ;
			$discount = round($discount, 2);
		    if( ($discount) > 0 ) :
		    	$html = '<span class="discount-negative">(-' . $discount . '%)</span>';
		    elseif( ($discount) < 0 ) :
		    	$html = '<span class="discount-positive">(+' . $discount * -1 . '%)</span>';
		    endif;

			return $html;
		endif;
	}





	public static function cartTotalAmount($store, $number = false)
	{
		$cart = session('cart-'.$store->id);
		$total = 0;


		if( count( $cart ) > 0 ) :
			foreach( $cart as $item ) :
				$total += $item['price'] * $item['quantity'];
			endforeach;
		endif;
		
		if( $number ) return $total;
		return self::currencyFormat($total);
	}




	public static function cartTotalItems($store)
	{
		$cart = session('cart-'.$store->id);
		if( count( $cart ) > 0 ) :
			return array_sum(array_column($cart, 'quantity')); 
		else :
			return 0;
		endif;
	}




	public static function isValidFacebookPage($facebook)
	{
		if( $facebook ) :
			$parse = parse_url($facebook);
			if( isset($parse["host"]) ) return false;

			$response = self::curl('https://graph.facebook.com/v2.10/'.$facebook.'?access_token=1208410692601134|Q-Ecl4J5fcGMu0aTmLixPCZMFqA');
			$response = json_decode($response);
			//print_r($response);
			if( !isset($response->error) ) :
				return true;
			endif;
			return false;
		else :
			return false;
		endif;
	}




	public static function generateFacebookLongLivedToken()
	{
		$ch = curl_init(); 

        curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/oauth/access_token?grant_type=fb_exchange_token&client_id=1208410692601134&client_secret=c7b0f9c5955ad8c03440e1d4f5560456&fb_exchange_token=EAARLCwoTRS4BAIhxUqo4gl9edxtlCeZClFZCL6X45KtVFfAZCaT6EgW9NqqQSdL5QJwcH2WXWymrO8nuGFfpqOVjiaQT9gTXUCjSlZCoSaTy5tQ81uN9d7mZBhTGwOAkoCoV57pi3dx8OfKQ8RNV4cZCoh9Q16loYj0MPmcQDh6Dp31NjOZCTRC73X9AwuYRXwZD"); 

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $outputxx = curl_exec($ch); 
        curl_close($ch); 
        print_r($outputxx);  
	}



	public static function validPHNumber($number)
	{
		return preg_match('/^$|^(09|){2}\d{9}$/', $number);
	}



	public static function human_date_diff($date){
	    $date = Carbon::parse($date);
	    return $date->diffForHumans(); 
	}



	public static function hasReviewed( $user, $product )
	{
		return \App\ProductReview::where('product_id', $product->id)->where('user_id', $user->id)->first();
	}


	public static function getRatingsAverageStars($product)
	{
		$ratings = floor($product->product_reviews->where('is_approved', true)->sum('rating') / $product->product_reviews->count());
		if( $ratings > 0 ) :
			for( $i = 0, $s = 5; $i < $ratings; $i++, $s-- ) : ?>
	    	<i class="fa fa-star text-yellow"></i>
	   	 	<?php 
	   	 	endfor;
	   	 	for( $i = 0; $i < $s; $i++ ) : ?>
	    	<i class="fa fa-star text-grey"></i>
	   	 	<?php endfor;
	   	 endif;
	}


	public static function getRatingsStars($ratings)
	{
		for( $i = 0, $s = 5; $i < $ratings; $i++, $s-- ) : ?>
    	<i class="fa fa-star text-yellow"></i>
   	 	<?php 
   	 	endfor;
   	 	for( $i = 0; $i < $s; $i++ ) : ?>
    	<i class="fa fa-star text-grey"></i>
   	 	<?php endfor;
	}




	public static function storeInTrial($store)
	{
        $created_at = Carbon::parse($store->created_at);
        $days = $created_at->diffInDays();
        return $days < 30;
	}



	public static function storeStatus($store, $attached = false)
	{
		$attached = $attached ? 'top right attached' : '';
        if( !$store->is_active && self::storeInTrial($store) ) :
        	return '<label class="ui yellow label '.$attached.' small">Trial</label>';
       	endif;

        $status = $store->is_active;
        switch( $status ) :
            case true :
                return '<label class="ui green label '.$attached.' small">Active</label>';
                break;
            case false :
                return '<label class="ui red label '.$attached.' small">Inactive</label>';
                break;
        endswitch;
	}




	public static function trialIndays($store)
	{
        $created_at = Carbon::parse($store->created_at);
        $days = $created_at->diffInDays();
        return 30 - $days;
	}


	public static function hasInvoice($store)
	{
		return \App\Invoice::where('store_id', $store->id)->orderBy('created_at', 'desc')->get()->filter(function($item){
              return !$item->isPaid;
            })->first();
	}


	
	public static function initialShippingRate($store, $weight)
	{
		$initial_shipping_rate = 0 ; 
		foreach( $store->shipping_methods as $shipping_method ) :
			if( $shipping_method->rates->count() > 0 ) :
				foreach( $shipping_method->rates as $rate ) :
					if( $weight >= $rate->min && $weight <= $rate->max ) :
						$initial_shipping_rate = $rate->rate;
						break;
					endif;
				endforeach;
				break;
			endif;
		endforeach;

		return $initial_shipping_rate;
	}






}