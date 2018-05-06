<?php
namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Requests\OrderItemCreateRequest;
use App\Http\Controllers\Controller;
use App\Store;
use App\Order;
use App\Product;
use App\OrderItem;
use Auth;

class OrderItemController extends Controller
{

	public function store( $store_id, $order_id, OrderItemCreateRequest $request)
	{
		$store = Store::findOrFail($store_id);
		$order = Order::findOrFail($order_id);
		$product = Product::findOrFail($request->product_id);

		$order_item_ids = $order->order_items->pluck('product_id')->toArray();

		if( 
			Auth::user()->can('manageStore', $store) && 
			Auth::user()->can('manageOrder', $order) && 
			Auth::user()->can('manageProduct', $product) &&
			$order->store_id == $store->id &&
			$product->store_id == $store->id
		) :
			if( !in_array( $product->id, $order_item_ids ) ) :
				$orderItem = new OrderItem();
				$orderItem->order_id = $order->id;
				$orderItem->product_id = $product->id;
				$orderItem->name = $product->title;
				$orderItem->price = $product->price;
				$orderItem->discounted_price = $product->discounted_price;
				$orderItem->quantity = $request->quantity;
				$orderItem->save();
			endif;
            return redirect()->back()->with('_notifyMessage', 'Order item successfully added.');
        else :
            return abort('403');
        endif;
	}





	public function destroy( $store_id, $order_id, $id, Request $request )
	{
		$store = Store::findOrFail($store_id);
		$order = Order::findOrFail($order_id);
		$orderItem = OrderItem::findOrFail($id);

        if( 
			Auth::user()->can('manageStore', $store) && 
			Auth::user()->can('manageOrder', $order) && 
			Auth::user()->can('manageOrderItem', $orderItem) &&
			$order->store_id == $store->id &&
			$orderItem->order_id == $order->id
		) :
        	$orderItem->forceDelete();
            return redirect()->back()->with('_notifyMessage', 'Order item successfully removed.');
        else :
            return abort('403');
        endif;

	}
}