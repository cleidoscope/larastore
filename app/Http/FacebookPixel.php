<?php
namespace App\Http;

use App\Store;
use Facebook\Facebook;
use Facebook\FacebookRequest;
use Facebook\FacebookApp;
use Facebook\FacebookResponse;
use Carbon\Carbon;

class FacebookPixel
{
	public $store;
	public $host;
	public $fb;
	public $pixel_ID;


	public function __construct($store_domain)
	{
		$this->fb = new Facebook([
            'app_id' => '1208410692601134', 
            'app_secret' => 'c7b0f9c5955ad8c03440e1d4f5560456',
            'default_access_token' => 'EAARLCwoTRS4BAMsgZBAidF1YhZA7CFuai15RILMoyijha7o8FRjtj5HxLWp0f3VY0BeTsN2pSQaYINPNT8H2GKJ5fA1YiKCeZCwAGnxuyfzSQ9ZBTqYhZCrEs8vaAWKxb1WvN7xZCxp6EPv4ttoT8iG8HqQom08ZAEZD'
        ]);
        $this->host = $store_domain;
        $this->pixel_ID = '1119867928114872';
	}



	public function PixelFires($start_time, $end_time)
	{
        $requestPixelFires = $this->pixel_ID.'/stats?aggregation=host&start_time='.$start_time.'&end_time='.$end_time;

        
        try {
            $response = $this->fb->sendRequest('GET', $requestPixelFires);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            //echo 'Graph returned an error: ' . $e->getMessage();
            return [];
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            //echo 'Facebook SDK returned an error: ' . $e->getMessage();
            return [];
        } catch(\Exception $e) {
            //echo 'Facebook SDK returned an error: ' . $e->getMessage();
            return [];
        }


        $pixel_fires = $output_fires = [];

        $feedEdge = $response->getGraphEdge();
        foreach ($feedEdge as $feed) :
            $data = $feed->getField('data')->asArray();
            foreach( $data as $content ) :
                $count = $content['count'];
                $host = $content['value'];

                if( $host == $this->host ) : // Filter results by hostname (subdomain)
                    $date = Carbon::parse($feed->getField('timestamp'));
                    $fire = [
                        'date'      =>  $date->addDays(1)->format('M d'),
                        'count'     =>  $count
                     ];
                    $pixel_fires[] = $fire;
                endif;
            endforeach;
        endforeach;


        $b = TRUE;
        while( $b ) :
            $nextFeed = $this->fb->next($feedEdge);
            if( count($nextFeed) == 0 ) :
                break;
            endif;
        endwhile;


        foreach( $pixel_fires as $fire ) :
            if( isset( $output_fires[$fire['date']] ) ) :
                $output_fires[$fire['date']] += $fire['count'];
            else :
                $output_fires[$fire['date']] = $fire['count'];
            endif;
        endforeach;
        return $output_fires;
	}




    public function AddToCarts($start_time, $end_time)
    {
        $requestAddToCarts = $this->pixel_ID.'/stats?aggregation=event&start_time='.$start_time.'&end_time='.$end_time;

        
        try {
            $response = $this->fb->sendRequest('GET', $requestAddToCarts);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            //echo 'Graph returned an error: ' . $e->getMessage();
            return [];
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            //echo 'Facebook SDK returned an error: ' . $e->getMessage();
            return [];
        } catch(\Exception $e) {
            //echo 'Facebook SDK returned an error: ' . $e->getMessage();
            return [];
        }


        $add_to_carts = $output_add_to_carts = [];

        $feedEdge = $response->getGraphEdge();

        foreach ($feedEdge as $feed) :
            $data = $feed->getField('data')->asArray();
            foreach( $data as $content ) :
                $count = $content['count'];
                $url = $content['value'];
                $host = $this->host;

                    $date = Carbon::parse(date_create($feed->getField('timestamp')));
                    $add_to_cart = [
                        'date'      =>  $date->addDays(1)->format('M d'),
                        'count'     =>  $count
                     ];
                    $add_to_carts[] = $add_to_cart;

                if( $host == $this->host ) : // Filter results by hostname (subdomain)
                endif;
            endforeach;
        endforeach;


        $b = TRUE;
        while( $b ) :
            $nextFeed = $this->fb->next($feedEdge);
            if( count($nextFeed) == 0 ) :
                break;
            endif;
        endwhile;


        foreach( $add_to_carts as $add_to_cart ) :
            if( isset( $output_add_to_carts[$add_to_cart['date']] ) ) :
                $output_add_to_carts[$add_to_cart['date']] += $add_to_cart['count'];
            else :
                $output_add_to_carts[$add_to_cart['date']] = $add_to_cart['count'];
            endif;
        endforeach;
        return $output_add_to_carts;
    }
}